<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    
    protected $table = 'clientes';
    
    protected $fillable = [
        'nome',
        'email',
        'telefone1',
        'telefone2',
        'cpf',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'observacoes',
        'ativo',
        'user_id',
    ];
    
    protected $casts = [
        'ativo' => 'boolean',
        'data_nascimento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    // Relacionamentos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
    
    // Scopes para consultas frequentes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
    
    public function scopeInativos($query)
    {
        return $query->where('ativo', false);
    }
    
    // Acessor para nome formatado
    public function getNomeCompletoAttribute()
    {
        return $this->nome;
    }
    
    // Acessor para endereço completo
    public function getEnderecoCompletoAttribute()
    {
        $endereco = "{$this->logradouro}, {$this->numero}";
        if ($this->complemento) {
            $endereco .= " - {$this->complemento}";
        }
        $endereco .= " - {$this->bairro}";
        $endereco .= " - {$this->cidade}/{$this->uf}";
        $endereco .= " - CEP: {$this->cep}";
        return $endereco;
    }

    // Adicione o relacionamento
    public function user()
        {
            return $this->belongsTo(User::class);
        }
}