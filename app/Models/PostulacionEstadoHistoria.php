<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionEstadoHistoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'postulacion_id',
        'estado_anterior',
        'estado_nuevo',
        'cambiado_por',
        'cambiado_en',
        'nota',
    ];

    protected $casts = [
        'cambiado_en' => 'datetime',
    ];

    public function postulacion()
    {
        return $this->belongsTo(Postulacion::class);
    }

    public function cambiadoPor()
    {
        return $this->belongsTo(User::class, 'cambiado_por');
    }
}
