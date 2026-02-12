<?php

namespace App\Observers;

use App\Models\KitRegistro;
use App\Models\KitEstadoHistoria;
use App\Models\User;
use App\Notifications\NuevoRegistroKitCreado;
use App\Notifications\KitEstadoCambiado;

class KitRegistroObserver
{
    public function created(KitRegistro $registro): void
    {
        // Historial inicial
        KitEstadoHistoria::create([
            'kit_registro_id' => $registro->id,
            'estado_anterior' => null,
            'estado_nuevo' => $registro->estado,
            'cambiado_por' => auth()->id(),
            'cambiado_en' => now(),
        ]);

        // Avisar a coordinador + gerente
        $targets = User::role('admin')->get();

        foreach ($targets as $u) {
            $u->notify(new NuevoRegistroKitCreado($registro));
        }
    }

    public function updating(KitRegistro $registro): void
    {
        if (! $registro->isDirty('estado')) return;

        $anterior = $registro->getOriginal('estado');
        $nuevo = $registro->estado;

        $registro->estado_actualizado_por = auth()->id();
        $registro->estado_actualizado_en = now();

        if ($nuevo === 'Aprobado' && $registro->fecha_aprobacion === null) $registro->fecha_aprobacion = now();
        if ($nuevo === 'Rechazado' && $registro->rechazado_en === null) $registro->rechazado_en = now();
        if ($nuevo === 'Entregado' && $registro->entregado_en === null) $registro->entregado_en = now();

        // Historial
        KitEstadoHistoria::create([
            'kit_registro_id' => $registro->id,
            'estado_anterior' => $anterior,
            'estado_nuevo' => $nuevo,
            'cambiado_por' => auth()->id(),
            'cambiado_en' => now(),
        ]);

        // Email al acudiente (dueño)
       // $registro->user?->notify(new KitEstadoCambiado($registro, $anterior));
    }
}
