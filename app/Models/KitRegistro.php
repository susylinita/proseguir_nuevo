<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KitRegistro extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'colaborador_nombre',
    'colaborador_documento',
    'linea_negocio',
    'area',
    'nino_nombre',
    'nino_documento',
    'edad',
    'grado',
    'institucion',
    'estado',
    'observaciones',
    'acepta_politica',
    'fecha_aceptacion_politica',
];

    protected $attributes = [
        'estado' => 'Pendiente',
    ];  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historicoEstados()
    {
        return $this->hasMany(KitEstadoHistoria::class);
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if ($model->acepta_politica) {
                $model->fecha_aceptacion_politica = now();
                $model->ip_aceptacion = request()->ip();
                $model->version_politica = 'v1.0_2026';
            }
        });
    }
}
