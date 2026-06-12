<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('cep_entrega', 10)->nullable()->after('cliente_id');
            $table->string('logradouro_entrega', 200)->nullable()->after('cep_entrega');
            $table->string('numero_entrega', 10)->nullable()->after('logradouro_entrega');
            $table->string('complemento_entrega', 100)->nullable()->after('numero_entrega');
            $table->string('bairro_entrega', 100)->nullable()->after('complemento_entrega');
            $table->string('cidade_entrega', 100)->nullable()->after('bairro_entrega');
            $table->string('uf_entrega', 2)->nullable()->after('cidade_entrega');
            
            $table->index('cep_entrega');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'cep_entrega',
                'logradouro_entrega',
                'numero_entrega',
                'complemento_entrega',
                'bairro_entrega',
                'cidade_entrega',
                'uf_entrega'
            ]);
        });
    }
};