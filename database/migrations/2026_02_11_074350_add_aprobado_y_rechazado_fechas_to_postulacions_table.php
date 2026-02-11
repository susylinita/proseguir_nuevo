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
        $table->timestamp('aprobado_en')->nullable()->after('estado_actualizado_en');
        $table->timestamp('rechazado_en')->nullable()->after('aprobado_en');
    });
}

public function down(): void
{
    Schema::table('postulacions', function (Blueprint $table) {
        $table->dropColumn(['aprobado_en', 'rechazado_en']);
    });
}
};
