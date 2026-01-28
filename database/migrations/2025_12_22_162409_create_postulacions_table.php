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
        Schema::create('postulacions', function (Blueprint $table) {
            $table->id();
            $table->string('estudiante_nombre');
            $table->string('estudiante_email');
            $table->float('puntaje_saber'); // Mínimo 300
            $table->float('promedio_universitario'); // Mínimo 3.8
            $table->enum('estado', ['Pendiente', 'Entrevista', 'Aprobado', 'Rechazado'])->default('Pendiente');
            $table->text('perfil_descriptivo')->nullable(); // Lo que llena la coordinadora
            $table->string('pdf_notas')->nullable();
            $table->string('pdf_matricula')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulacions');
    }
};
