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
        $table->timestamp('fecha_aprobacion')->nullable()->after('estado_actualizado_en');
        $table->timestamp('rechazado_en')->nullable()->after('fecha_aprobacion');
    });
}

public function down(): void
{
    Schema::table('postulacions', function (Blueprint $table) {
        $table->dropColumn(['fecha_aprobacion', 'rechazado_en']);
    });
}
};
