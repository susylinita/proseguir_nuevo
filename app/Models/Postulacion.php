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

        'observaciones_entrevista',

        // existentes
        'puntaje_saber',
        'promedio_universitario',
        'estado',
        'perfil_descriptivo',
        'pdf_notas',
        'pdf_matricula',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'cuenta_actualizada' => 'boolean',
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
}

