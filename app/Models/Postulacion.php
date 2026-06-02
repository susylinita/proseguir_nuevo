<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_postulacion',

        'estudiante_nombre',
        'estudiante_email',
        'fecha_nacimiento',
        'tipo_documento',
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

        'entrevista_observaciones',
        'entrevista_recomendado',
        'entrevista_semaforo',
        'entrevista_registrada_por',
        'entrevista_registrada_en',

        // existentes
        'puntaje_saber',
        'promedio_universitario',
        'estado',
        'perfil_descriptivo',
        'pdf_notas',
        'pdf_matricula',

        'acepta_politica',
        'fecha_aceptacion_politica',

        'gerencia_observaciones',
        'gerencia_observaciones_por',
        'gerencia_observaciones_en',
    ];

    protected $casts = [
    'entrevista_recomendado' => 'boolean',
    'entrevista_registrada_en' => 'datetime',
    'gerencia_observaciones_en' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historicoEstados()
    {
        return $this->hasMany(\App\Models\PostulacionEstadoHistoria::class);
    }

    public function promedios()
    {
        return $this->hasMany(\App\Models\PostulacionPromedio::class);
    }

    public function estadoActualizadoPor()
    {
        return $this->belongsTo(\App\Models\User::class, 'estado_actualizado_por');
    }

        protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->acepta_tratamiento_datos) {
                $model->fecha_aceptacion_politica = now();
                $table->string('ip_aceptacion')->nullable();
                $table->string('version_politica')->nullable();
            }
        });
    }


}

