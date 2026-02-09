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
            $table->unsignedBigInteger('estado_actualizado_por')->nullable()->after('estado');
            $table->timestamp('estado_actualizado_en')->nullable()->after('estado_actualizado_por');

            $table->foreign('estado_actualizado_por')
                ->references('id')->on('users')
                ->nullOnDelete();
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
