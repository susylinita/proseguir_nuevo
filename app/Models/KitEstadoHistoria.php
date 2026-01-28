<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitEstadoHistoria extends Model
{
    protected $fillable = [
        'kit_registro_id','estado_anterior','estado_nuevo','cambiado_por','cambiado_en'
    ];
}
