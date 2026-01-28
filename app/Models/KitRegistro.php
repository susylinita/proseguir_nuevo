<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KitRegistro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nino_nombre',
        'nino_documento',
        'nino_fecha_nacimiento',
        'institucion',
        'grado',
        'estado',
        'observaciones',
        'pdf_documento',
        'pdf_certificado',
        'aprobado_en',
        'rechazado_en',
        'entregado_en',
    ];

    protected $casts = [
        'nino_fecha_nacimiento' => 'date',
        'aprobado_en' => 'datetime',
        'rechazado_en' => 'datetime',
        'entregado_en' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historicoEstados()
    {
        return $this->hasMany(KitEstadoHistoria::class);
    }
}
