<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostulacionEstadoCambiado extends Notification
{
    use Queueable;

    public function __construct(public \App\Models\Postulacion $postulacion, public ?string $estadoAnterior) {}

public function via($notifiable): array
    {
        return ['mail'];
    }

public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Actualización de tu postulación')
            ->greeting('Hola, ' . ($this->postulacion->estudiante_nombre ?? ''))
            ->line('Tu postulación #' . $this->postulacion->id . ' cambió de estado.')
            ->line('Estado anterior: ' . ($this->estadoAnterior ?? 'N/D'))
            ->line('Estado nuevo: ' . $this->postulacion->estado)
            ->action('Ver mi postulación', url('/mi-portal/postulaciones/' . $this->postulacion->id))
            ->line('Fundación Proseguir');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
