<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            $table->text('entrevista_observaciones')->nullable()->after('perfil_descriptivo');
            $table->boolean('entrevista_recomendado')->default(false)->after('entrevista_observaciones');
            $table->string('entrevista_semaforo')->nullable()->after('entrevista_recomendado');
            $table->foreignId('entrevista_registrada_por')->nullable()->after('entrevista_semaforo')->constrained('users')->nullOnDelete();
            $table->timestamp('entrevista_registrada_en')->nullable()->after('entrevista_registrada_por');
        });
    }

    public function down(): void
    {
        Schema::table('postulacions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('entrevista_registrada_por');
            $table->dropColumn([
                'entrevista_observaciones',
                'entrevista_recomendado',
                'entrevista_semaforo',
                'entrevista_registrada_en',
            ]);
        });
    }
};