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
        $table->json('semestres_promedios')->nullable()->after('promedio_universitario');
    });
}

public function down(): void
{
    Schema::table('postulacions', function (Blueprint $table) {
        $table->dropColumn('semestres_promedios');
    });
}
};
