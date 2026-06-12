<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('localizacao', 255)->nullable()->after('uf_entrega');
            $table->string('latitude', 20)->nullable()->after('localizacao');
            $table->string('longitude', 20)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['localizacao', 'latitude', 'longitude']);
        });
    }
};