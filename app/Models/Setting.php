<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['valor_aprobado'];

    public static function current(): self
    {
        // Garantiza que exista siempre 1 fila
        return static::query()->firstOrCreate([], ['valor_aprobado' => 0]);
    }
}
