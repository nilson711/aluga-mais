<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('itens_pedido', function (Blueprint $table) {
            // Adicionar coluna data_devolucao_real para registrar quando o item foi devolvido
            $table->datetime('data_devolucao_real')->nullable()->after('devolvido');
        });
    }

    public function down(): void
    {
        Schema::table('itens_pedido', function (Blueprint $table) {
            $table->dropColumn('data_devolucao_real');
        });
    }
};