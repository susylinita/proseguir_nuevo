<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostulacionPromedio extends Model
{
    protected $fillable = ['postulacion_id', 'semestre', 'promedio', 'periodo'];

    public function postulacion()
    {
        return $this->belongsTo(Postulacion::class);
    }
}
