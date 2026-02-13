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

        if (!Schema::hasColumn('kit_registros', 'colaborador_nombre')) {
            $table->string('colaborador_nombre')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'colaborador_documento')) {
            $table->string('colaborador_documento')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'linea_negocio')) {
            $table->string('linea_negocio')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'area')) {
            $table->string('area')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'nino_nombre')) {
            $table->string('nino_nombre')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'nino_documento')) {
            $table->string('nino_documento')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'edad')) {
            $table->integer('edad')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'grado')) {
            $table->string('grado')->nullable();
        }

        if (!Schema::hasColumn('kit_registros', 'institucion')) {
            $table->string('institucion')->nullable();
        }
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
