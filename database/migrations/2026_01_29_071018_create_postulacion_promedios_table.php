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
    Schema::create('postulacion_promedios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('postulacion_id')->constrained('postulacions')->cascadeOnDelete();
        $table->unsignedTinyInteger('semestre');
        $table->decimal('promedio', 4, 2);
        $table->string('periodo')->nullable(); // ej: 2026-1
        $table->timestamps();

        $table->unique(['postulacion_id', 'semestre']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulacion_promedios');
    }
};
