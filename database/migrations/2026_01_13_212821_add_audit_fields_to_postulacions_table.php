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
            $table->foreignId('estado_actualizado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('estado_actualizado_en')->nullable();

            $table->timestamp('aprobado_en')->nullable();
            $table->timestamp('rechazado_en')->nullable();
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
