<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kit_registros', function (Blueprint $table) {
            $table->id();

            // Relación con usuario (NECESARIO)
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // ======================
            // DATOS COLABORADOR
            // ======================
            $table->string('colaborador_nombre');
            $table->string('colaborador_documento');
            $table->string('linea_negocio');
            $table->string('area');

            // ======================
            // DATOS NIÑO
            // ======================
            $table->string('nino_nombre');
            $table->string('nino_documento');
            $table->integer('edad');
            $table->string('grado');
            $table->string('institucion');

            // Estado (lo usa tu vista show)
            $table->enum('estado', ['Pendiente', 'Aprobado', 'Rechazado', 'Entregado'])
                ->default('Pendiente');

            // Observaciones (lo usa tu modelo)
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kit_registros');
    }
};
