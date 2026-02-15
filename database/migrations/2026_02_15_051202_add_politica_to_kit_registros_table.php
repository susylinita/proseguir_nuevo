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
        $table->boolean('acepta_politica')->default(false);
        $table->timestamp('fecha_aceptacion_politica')->nullable();
        $table->string('ip_aceptacion')->nullable();
        $table->string('version_politica')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kit_registros', function (Blueprint $table) {
            //
        });
    }
};
