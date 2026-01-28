<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kit_registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // acudiente
            $table->string('nino_nombre');
            $table->string('nino_documento')->nullable();
            $table->date('nino_fecha_nacimiento')->nullable();
            $table->string('institucion')->nullable();
            $table->string('grado')->nullable();

            $table->enum('estado', ['Pendiente', 'Aprobado', 'Rechazado', 'Entregado'])->default('Pendiente');
            $table->text('observaciones')->nullable();

            // Soportes (ajusta según tus requisitos)
            $table->string('pdf_documento')->nullable();
            $table->string('pdf_certificado')->nullable();

            $table->timestamp('aprobado_en')->nullable();
            $table->timestamp('rechazado_en')->nullable();
            $table->timestamp('entregado_en')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kit_registros');
    }
};
