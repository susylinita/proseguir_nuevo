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
        // Tipo de beca (3 grupos)
        $table->enum('tipo_postulacion', ['primer_semestre', 'otro_semestre', 'renovacion'])
            ->default('primer_semestre')
            ->after('id');

        // Datos personales
        $table->date('fecha_nacimiento')->nullable()->after('estudiante_email');
        $table->string('documento_identidad')->nullable()->after('fecha_nacimiento');
        $table->string('telefono_fijo')->nullable();
        $table->string('telefono_celular')->nullable();
        $table->string('direccion')->nullable();
        $table->string('barrio')->nullable();
        $table->enum('genero', ['F', 'M', 'Otro', 'Prefiero no decir'])->nullable();

        // Acudiente
        $table->string('nombre_acudiente')->nullable();
        $table->string('telefono_acudiente')->nullable();

        // Estudios (según tipo)
        $table->string('universidad_actual')->nullable(); // para estudiante activo
        $table->string('carrera_actual')->nullable();     // pregrado
        $table->unsignedTinyInteger('semestre_en_curso')->nullable();

        $table->string('universidad_aplica')->nullable(); // para primer semestre
        $table->string('carrera_aplica')->nullable();     // pregrado

        // Pregunta abierta
        $table->text('como_encontro')->nullable();

        // Datos bancarios
        $table->string('banco')->nullable();
        $table->string('titular_cuenta')->nullable();
        $table->enum('tipo_cuenta', ['Ahorros', 'Corriente'])->nullable();
        $table->string('numero_cuenta')->nullable();
        $table->boolean('cuenta_actualizada')->default(false);

        // Anexos nuevos (pdf/jpg)
        $table->string('anexo_doc_identidad')->default('')->after('cuenta_actualizada');
        $table->string('anexo_foto_documento')->default('')->after('anexo_doc_identidad');
        $table->string('anexo_certificado_bancario')->default('')->after('anexo_foto_documento');

        // Promedio carrera (dato)
        $table->decimal('promedio_carrera', 4, 2)->nullable();

        // Renovación: anexos específicos
        $table->string('anexo_certificado_notas')->nullable();
        $table->string('anexo_recibo_matricula')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('postulacions', function (Blueprint $table) {
        $table->dropColumn([
            'tipo_postulacion',
            'fecha_nacimiento',
            'documento_identidad',
            'telefono_fijo',
            'telefono_celular',
            'direccion',
            'barrio',
            'genero',
            'nombre_acudiente',
            'telefono_acudiente',
            'universidad_actual',
            'carrera_actual',
            'semestre_en_curso',
            'universidad_aplica',
            'carrera_aplica',
            'como_encontro',
            'banco',
            'titular_cuenta',
            'tipo_cuenta',
            'numero_cuenta',
            'cuenta_actualizada',
            'anexo_doc_identidad',
            'anexo_foto_documento',
            'anexo_certificado_bancario',
            'promedio_carrera',
            'anexo_certificado_notas',
            'anexo_recibo_matricula',
        ]);
    });
}

};
