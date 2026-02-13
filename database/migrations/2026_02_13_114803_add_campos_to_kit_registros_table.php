<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('kit_registros', function (Blueprint $table) {
        $table->string('colaborador_nombre')->nullable();
        $table->string('colaborador_documento')->nullable();
        $table->string('linea_negocio')->nullable();
        $table->string('area')->nullable();
        $table->string('nino_nombre')->nullable();
        $table->string('nino_documento')->nullable();
        $table->integer('edad')->nullable();
        $table->string('grado')->nullable();
        $table->string('institucion')->nullable();
    });
}

public function down(): void
{
    Schema::table('kit_registros', function (Blueprint $table) {
        $table->dropColumn([
            'colaborador_nombre',
            'colaborador_documento',
            'linea_negocio',
            'area',
            'nino_nombre',
            'nino_documento',
            'edad',
            'grado',
            'institucion',
        ]);
    });
}

};
