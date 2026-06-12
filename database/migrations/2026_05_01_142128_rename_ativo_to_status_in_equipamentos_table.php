<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            // Renomear a coluna
            $table->renameColumn('ativo', 'status');
            
            // Alterar o tipo de boolean para string
            $table->string('status')->default('Disponível')->change();
        });
        
        // Atualizar os valores existentes
        // true (ativo) = 'Disponível'
        // false (inativo) = 'Vendido' (ou 'Manutenção' conforme sua regra)
        DB::table('equipamentos')->update([
            'status' => DB::raw("CASE 
                WHEN status::boolean = true THEN 'Disponível' 
                ELSE 'Vendido' 
            END")
        ]);
    }

    public function down(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            // Reverter os valores
            DB::table('equipamentos')->update([
                'status' => DB::raw("CASE 
                    WHEN status = 'Disponível' THEN true 
                    ELSE false 
                END")
            ]);
            
            // Alterar tipo de volta para boolean
            $table->boolean('status')->change();
            $table->renameColumn('status', 'ativo');
        });
    }
};