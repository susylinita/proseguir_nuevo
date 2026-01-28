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
        Schema::create('kit_escolars', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_estudiante');
            $table->string('grado_escolar');
            $table->string('tipo_kit'); // Ejemplo: Kit A (Cuadernos), Kit B (Mochila)
            $table->date('fecha_entrega');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kit_escolars');
    }
};
