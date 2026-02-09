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
            $table->longText('observaciones_entrevista')
                ->nullable()
                ->after('perfil_descriptivo'); // o donde prefieras
        });
    }

    public function down(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            $table->dropColumn('observaciones_entrevista');
        });
    }

};
