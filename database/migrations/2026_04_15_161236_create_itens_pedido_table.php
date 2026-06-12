<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itens_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('restrict');
            $table->integer('quantidade')->default(1);
            $table->decimal('preco_unitario', 10, 2); // Preço no momento do pedido
            $table->decimal('subtotal', 10, 2);
            $table->text('observacoes')->nullable();

            $table->boolean('devolvido')->default(false);
            $table->datetime('data_devolucao_item')->nullable();

            $table->timestamps();
            
            // Índices compostos
            $table->unique(['pedido_id', 'equipamento_id']); // Evita duplicidade
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itens_pedido');
    }
};