<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Aumentar para 20 caracteres (comporta telefone com DD + 9 dígitos + máscara)
            $table->string('telefone1', 20)->change();
            $table->string('telefone2', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('telefone1', 15)->change();
            $table->string('telefone2', 15)->nullable()->change();
        });
    }
};