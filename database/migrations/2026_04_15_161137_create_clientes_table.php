<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('email', 100)->nullable()->unique();
            $table->string('telefone1', 20);
            $table->string('telefone2', 20)->nullable();
            $table->string('cpf', 14)->unique();
            $table->string('cep', 10);
            $table->string('logradouro', 200);
            $table->string('numero', 10);
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 100);
            $table->string('cidade', 100);
            $table->string('uf', 2);
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes(); // Para não excluir permanentemente
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};