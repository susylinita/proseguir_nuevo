<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('kit_escolars') && !Schema::hasColumn('kit_escolars', 'linea_negocio')) {
            Schema::table('kit_escolars', function (Blueprint $table) {
                $table->string('linea_negocio')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('kit_escolars') && Schema::hasColumn('kit_escolars', 'linea_negocio')) {
            Schema::table('kit_escolars', function (Blueprint $table) {
                $table->dropColumn('linea_negocio');
            });
        }
    }
};