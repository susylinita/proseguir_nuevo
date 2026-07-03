<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\KitRegistro;

class KitEstadoCambiado extends Notification
{
    public function __construct(
        public KitRegistro $registro,
        public ?string $estadoAnterior
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Actualización de estado – Kit Escolar')
            ->greeting('Hola ' . $notifiable->name)
            ->line('El estado del registro de Kit Escolar ha cambiado.')
            ->line('Niño: ' . $this->registro->nino_nombre)
            ->line('Estado anterior: ' . ($this->estadoAnterior ?? 'N/A'))
            ->line('Estado actual: ' . $this->registro->estado)
            ->action(
                'Ver mi registro',
                route('kits.registros.show', $this->registro)
            )
            ->line('Si tienes dudas, puedes comunicarte con la Fundación Proseguir.');
    }
}
