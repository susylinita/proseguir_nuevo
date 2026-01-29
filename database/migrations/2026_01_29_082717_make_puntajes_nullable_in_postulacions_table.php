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
            $table->float('puntaje_saber')->nullable()->change();
            $table->float('promedio_universitario')->nullable()->change();
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
