<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('marca', 50)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->string('categoria', 50)->nullable(); // Ex: 'Mesa', 'Cadeira', 'Freezer', 'Tenda'
            
            $table->text('observacoes')->nullable();
            
            $table->decimal('preco_diaria', 10, 2)->nullable();
            $table->decimal('preco_semanal', 10, 2)->nullable();
            $table->decimal('preco_mensal', 10, 2)->nullable();
            $table->decimal('caucao', 10, 2)->nullable(); // Valor de garantia
            $table->string('foto')->nullable(); // Caminho da imagem
            $table->text('especificacoes')->nullable();
            $table->boolean('ativo')->default(true);

            $table->date('data_aquisicao')->nullable();
            $table->decimal('valor_aquisicao', 10, 2)->nullable();
            $table->date('data_venda')->nullable();
            $table->decimal('valor_venda', 10, 2)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para buscas
            $table->index('categoria');
            $table->index('ativo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};