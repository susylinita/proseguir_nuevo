<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE postulacions 
            MODIFY tipo_postulacion ENUM(
                'primer_semestre',
                'otro_semestre',
                'renovacion',
                'becado_actual'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE postulacions 
            MODIFY tipo_postulacion ENUM(
                'primer_semestre',
                'otro_semestre',
                'renovacion'
            ) NOT NULL
        ");
    }
};