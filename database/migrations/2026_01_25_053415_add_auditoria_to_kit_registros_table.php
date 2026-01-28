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
            $table->foreignId('estado_actualizado_por')->nullable()->after('estado')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('estado_actualizado_en')->nullable()->after('estado_actualizado_por');
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
