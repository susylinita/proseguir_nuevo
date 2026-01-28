<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'estudiante_nombre',
        'estudiante_email',
        'puntaje_saber',
        'promedio_universitario',
        'estado',
        'perfil_descriptivo',
        'pdf_notas',
        'pdf_matricula',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historicoEstados()
    {
        return $this->hasMany(\App\Models\PostulacionEstadoHistoria::class);
    }

}

