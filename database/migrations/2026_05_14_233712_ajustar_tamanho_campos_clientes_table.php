<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Ajustar tamanho dos campos
            $table->string('telefone1', 15)->change();      // (99) 99999-9999 = 15 caracteres
            $table->string('telefone2', 15)->nullable()->change();
            $table->string('cpf', 14)->change();            // 111.111.111-11 = 14 caracteres
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('telefone1', 20)->change();
            $table->string('telefone2', 20)->nullable()->change();
            $table->string('cpf', 20)->change();
        });
    }
};