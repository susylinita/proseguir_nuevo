<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaPostulacionCreada extends Notification
{
    use Queueable;

    public function __construct(public \App\Models\Postulacion $postulacion) {}

public function via($notifiable): array
    {
        return ['mail'];
    }

public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Nueva postulación creada')
            ->line('Se creó la postulación #' . $this->postulacion->id)
            ->line('Estudiante: ' . $this->postulacion->estudiante_nombre)
            ->line('Email: ' . $this->postulacion->estudiante_email)
            ->action('Ver en panel', url('/admin/postulacions/' . $this->postulacion->id));
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
