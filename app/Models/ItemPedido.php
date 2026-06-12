<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = 'itens_pedido';
    
    protected $fillable = [
        'pedido_id',
        'equipamento_id',
        'quantidade',
        'preco_unitario',
        'subtotal',
        'observacoes',
        'devolvido',
        'data_devolucao_real',
    ];
    
    protected $casts = [
        'quantidade' => 'integer',
        'preco_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'devolvido' => 'boolean',
        'data_devolucao_real' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Calcular subtotal automaticamente
    protected static function booted()
    {
        static::creating(function ($item) {
            $item->subtotal = $item->quantidade * $item->preco_unitario;
        });
        
        static::updating(function ($item) {
            if ($item->isDirty('quantidade') || $item->isDirty('preco_unitario')) {
                $item->subtotal = $item->quantidade * $item->preco_unitario;
            }
            
            // Se o item foi marcado como devolvido agora
            if ($item->isDirty('devolvido') && $item->devolvido === true && !$item->data_devolucao_real) {
                $item->data_devolucao_real = now();
            }
        });
    }
    
    // Relacionamentos
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
    
    // Scopes
    public function scopeNaoDevolvidos($query)
    {
        return $query->where('devolvido', false);
    }
    
    public function scopeDevolvidos($query)
    {
        return $query->where('devolvido', true);
    }
    
    // Acessor para subtotal formatado
    public function getSubtotalFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->subtotal, 2, ',', '.');
    }
    
    public function getPrecoUnitarioFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco_unitario, 2, ',', '.');
    }
    
    // Registrar devolução
    public function registrarDevolucao()
    {
        $this->update([
            'devolvido' => true,
            'data_devolucao_real' => now(),
        ]);
    }
}