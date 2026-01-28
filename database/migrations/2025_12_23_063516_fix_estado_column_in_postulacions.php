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
    Schema::table('postulacions', function (Blueprint $table) {
        // Cambiamos a string para que acepte cualquier estado sin errores
        $table->string('estado')->default('Pendiente')->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            //
        });
    }
};
