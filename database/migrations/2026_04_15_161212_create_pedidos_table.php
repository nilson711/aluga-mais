<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            
            $table->datetime('data_entrega'); 
            $table->datetime('data_devolucao');
            $table->integer('dias_totais'); 
            $table->decimal('subtotal', 10, 2);
            $table->decimal('desconto', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('status', 30)->default('pendente'); 
            $table->text('observacoes')->nullable();
            $table->string('forma_pagamento', 50)->nullable();
            $table->decimal('caucao_pago', 10, 2)->default(0);
            $table->timestamps(); // created_at e updated_at
            
            // Índices
            $table->index('status');
            $table->index('created_at'); 
            $table->index('cliente_id');
            $table->index('data_entrega');    
            $table->index('data_devolucao');  
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};