<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipamento extends Model
{
    use SoftDeletes;
    
    protected $table = 'equipamentos';
    
    protected $fillable = [
        'numero_patrimonio',
        'nome',
        'marca',
        'modelo',
        'categoria',
        'observacoes',
        'preco_diaria',
        'preco_semanal',
        'preco_mensal',
        'caucao',
        'foto',
        'especificacoes',
        'status',
        'data_aquisicao',
        'valor_aquisicao',
        'data_venda',
        'valor_venda',
        'user_id',
    ];
    
    // ✅ Casts unificado (apenas um array)
    protected $casts = [
        'status' => 'string',
        'preco_diaria' => 'decimal:2',
        'preco_semanal' => 'decimal:2',
        'preco_mensal' => 'decimal:2',
        'caucao' => 'decimal:2',
        'valor_aquisicao' => 'decimal:2',
        'valor_venda' => 'decimal:2',
        'data_aquisicao' => 'date',
        'data_venda' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Constantes para os status (boa prática)
    const STATUS_DISPONIVEL = 'Disponível';
    const STATUS_ALUGADO = 'Alugado';
    const STATUS_MANUTENCAO = 'Manutenção';
    const STATUS_VENDIDO = 'Vendido';

    // Métodos para verificar status
    public function isDisponivel()
    {
        return $this->status === self::STATUS_DISPONIVEL;
    }

    public function isAlugado()
    {
        return $this->status === self::STATUS_ALUGADO;
    }

    public function isManutencao()
    {
        return $this->status === self::STATUS_MANUTENCAO;
    }

    public function isVendido()
    {
        return $this->status === self::STATUS_VENDIDO;
    }

    // Scopes para consultas
    public function scopeDisponiveis($query)
    {
        return $query->where('status', self::STATUS_DISPONIVEL);
    }

    public function scopeAlugados($query)
    {
        return $query->where('status', self::STATUS_ALUGADO);
    }

    public function scopeEmManutencao($query)
    {
        return $query->where('status', self::STATUS_MANUTENCAO);
    }

    public function scopeVendidos($query)
    {
        return $query->where('status', self::STATUS_VENDIDO);
    }



    // ✅ Gerar número de patrimônio automaticamente (apenas se vazio)
    protected static function booted()
    {
        static::creating(function ($equipamento) {
            // Se não foi informado manualmente, gera automaticamente
            if (empty($equipamento->numero_patrimonio)) {
                $equipamento->numero_patrimonio = static::gerarNumeroPatrimonio();
            }
        });
    }
    
    // Método para gerar número de patrimônio
    public static function gerarNumeroPatrimonio()
    {
        // Formato: PAT + ano + mês + sequencial de 4 dígitos
        // Exemplo: PAT2025040001
        
        $anoMes = date('Ym'); // 202504
        $ultimo = static::where('numero_patrimonio', 'like', "PAT{$anoMes}%")
            ->orderBy('numero_patrimonio', 'desc')
            ->first();
        
        if ($ultimo && $ultimo->numero_patrimonio) {
            $sequencial = (int) substr($ultimo->numero_patrimonio, -4) + 1;
            $sequencial = str_pad($sequencial, 4, '0', STR_PAD_LEFT);
        } else {
            $sequencial = '0001';
        }
        
        return "PAT{$anoMes}{$sequencial}";
    }
    
    // Método para validar número único
    public static function validarNumeroPatrimonio($numero, $ignoreId = null)
    {
        $query = static::where('numero_patrimonio', $numero);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        return !$query->exists();
    }
    
    // Relacionamentos
    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class);
    }
    
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }
    
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
    
    // Acessor para preço formatado
    public function getPrecoDiariaFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco_diaria, 2, ',', '.');
    }
    
    // Acessor para lucro/prejuízo na venda
    public function getLucroPrejuizoAttribute()
    {
        if ($this->data_venda && $this->valor_venda && $this->valor_aquisicao) {
            return $this->valor_venda - $this->valor_aquisicao;
        }
        return null;
    }

    // Adicione o relacionamento
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}