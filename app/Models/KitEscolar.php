<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class KitEscolar extends Model
{
    use HasFactory;
    protected $fillable = [
    'nombre_estudiante',
    'grado_escolar',
    'tipo_kit',
    'fecha_entrega',
    'observaciones',
];
}
