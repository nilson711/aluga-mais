<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $table = 'pedidos';
    
    protected $fillable = [
        'cliente_id',
        'cep_entrega',
        'logradouro_entrega',
        'numero_entrega',
        'complemento_entrega',
        'bairro_entrega',
        'cidade_entrega',
        'uf_entrega',
        'data_entrega',
        'data_devolucao',
        'dias_totais',
        'subtotal',
        'taxa_entrega',
        'desconto',
        'total',
        'status',
        'observacoes',
        'forma_pagamento',
        'caucao_pago',
        'localizacao',
        'latitude',
        'longitude',
    ];
    
    protected $casts = [
        'data_entrega' => 'datetime',
        'data_devolucao' => 'datetime',
        'subtotal' => 'decimal:2',
        'desconto' => 'decimal:2',
        'total' => 'decimal:2',
        'caucao_pago' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    protected static function booted()
    {
        // Calcular dias totais antes de salvar
        static::saving(function ($pedido) {
            if ($pedido->data_entrega && $pedido->data_devolucao) {
                $pedido->dias_totais = $pedido->data_entrega->diffInDays($pedido->data_devolucao);
            }
        });
    }
    
    // Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }
    
    // Calcular totais do pedido
    public function calcularTotais()
    {
        $this->subtotal = $this->itens->sum('subtotal');
        $this->total = $this->subtotal - $this->desconto;
        return $this;
    }
    
    // Verificar se todos os itens foram devolvidos
    public function itensDevolvidos()
    {
        return $this->itens->where('devolvido', true)->count();
    }
    
    public function itesPendentesDevolucao()
    {
        return $this->itens->where('devolvido', false)->count();
    }
    
    public function todosItensDevolvidos()
    {
        return $this->itens->every(fn($item) => $item->devolvido === true);
    }
    
    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }
    
    public function scopeAprovados($query)
    {
        return $query->where('status', 'aprovado');
    }
    
    public function scopeRetirados($query)
    {
        return $query->where('status', 'retirado');
    }
    
    public function scopeDevolvidos($query)
    {
        return $query->where('status', 'devolvido');
    }
    
    public function scopeCancelados($query)
    {
        return $query->where('status', 'cancelado');
    }
    
    public function scopePorPeriodo($query, $startDate, $endDate)
    {
        return $query->whereBetween('data_entrega', [$startDate, $endDate]);
    }
    
    // Acessor para valor formatado
    public function getTotalFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->total, 2, ',', '.');
    }
    
    public function getSubtotalFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->subtotal, 2, ',', '.');
    }
    
    public function getDescontoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->desconto, 2, ',', '.');
    }
    
    // Mutator para desconto
    public function setDescontoAttribute($value)
    {
        $this->attributes['desconto'] = $value;
        if (isset($this->attributes['subtotal'])) {
            $this->attributes['total'] = $this->attributes['subtotal'] - $value;
        }
    }

    // Adicione o relacionamento
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}