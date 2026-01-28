<?php

namespace App\Observers;

use App\Models\Postulacion;
use App\Models\PostulacionEstadoHistoria;
use App\Models\User;
use App\Notifications\PostulacionEstadoCambiado;
use App\Notifications\NuevaPostulacionCreada;
use Illuminate\Support\Facades\Notification;

class PostulacionObserver
{
    public function created(Postulacion $postulacion): void
    {
        // Log inicial al historial
        PostulacionEstadoHistoria::create([
            'postulacion_id' => $postulacion->id,
            'estado_anterior' => null,
            'estado_nuevo' => $postulacion->estado,
            'cambiado_por' => auth()->id(),
            'cambiado_en' => now(),
        ]);

        // Avisar a coordinadores (y/o gerente) por email
        $admins = User::role('coordinador')->get()->merge(User::role('gerente')->get());

        foreach ($admins as $admin) {
            $admin->notify(new NuevaPostulacionCreada($postulacion));
        }
    }

    public function updating(Postulacion $postulacion): void
    {
        if (! $postulacion->isDirty('estado')) {
            return;
        }

        $estadoAnterior = $postulacion->getOriginal('estado');
        $estadoNuevo = $postulacion->estado;
        $userId = auth()->id();

        // Campos de auditoría (último cambio)
        $postulacion->estado_actualizado_por = $userId;
        $postulacion->estado_actualizado_en = now();

        // Fechas de aprobación/rechazo
        if ($estadoNuevo === 'Aprobado' && $postulacion->aprobado_en === null) {
            $postulacion->aprobado_en = now();
        }

        if ($estadoNuevo === 'Rechazado' && $postulacion->rechazado_en === null) {
            $postulacion->rechazado_en = now();
        }

        // Historial
        PostulacionEstadoHistoria::create([
            'postulacion_id' => $postulacion->id,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo,
            'cambiado_por' => $userId,
            'cambiado_en' => now(),
        ]);

        // Email al estudiante (usar el correo que está en la postulación)
        if (!empty($postulacion->estudiante_email)) {
            \Illuminate\Support\Facades\Notification::route('mail', $postulacion->estudiante_email)
                ->notify(new \App\Notifications\PostulacionEstadoCambiado($postulacion, $estadoAnterior));
        }

    }
}
