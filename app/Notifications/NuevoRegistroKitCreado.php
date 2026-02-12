<?php

namespace App\Notifications;

use App\Models\KitRegistro;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Filament\Resources\KitEscolarResource;


class NuevoRegistroKitCreado extends Notification
{
    use Queueable;

    public function __construct(
        public KitRegistro $registro
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = KitEscolarResource::getUrl('edit', [
            'record' => $this->registro,
        ], panel: 'admin');

        return (new MailMessage)
            ->subject('Nuevo registro de Kit Escolar')
            ->line('Se ha creado un nuevo registro de kit escolar.')
            ->line('Niño: ' . $this->registro->nino_nombre)
            ->action('Abrir en el panel', url($url));
    }
}
