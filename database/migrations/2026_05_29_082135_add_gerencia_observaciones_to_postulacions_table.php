<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            if (! Schema::hasColumn('postulacions', 'gerencia_observaciones')) {
                $table->text('gerencia_observaciones')->nullable()->after('perfil_descriptivo');
            }

            if (! Schema::hasColumn('postulacions', 'gerencia_observaciones_por')) {
                $table->foreignId('gerencia_observaciones_por')
                    ->nullable()
                    ->after('gerencia_observaciones')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('postulacions', 'gerencia_observaciones_en')) {
                $table->timestamp('gerencia_observaciones_en')
                    ->nullable()
                    ->after('gerencia_observaciones_por');
            }
        });
    }

    public function down(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            if (Schema::hasColumn('postulacions', 'gerencia_observaciones_por')) {
                $table->dropConstrainedForeignId('gerencia_observaciones_por');
            }

            if (Schema::hasColumn('postulacions', 'gerencia_observaciones')) {
                $table->dropColumn('gerencia_observaciones');
            }

            if (Schema::hasColumn('postulacions', 'gerencia_observaciones_en')) {
                $table->dropColumn('gerencia_observaciones_en');
            }
        });
    }
};