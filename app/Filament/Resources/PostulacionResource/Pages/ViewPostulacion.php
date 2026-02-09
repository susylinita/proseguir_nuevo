<?php

namespace App\Filament\Resources\PostulacionResource\Pages;

use App\Filament\Resources\PostulacionResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Actions\Action as InfolistAction;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;

class ViewPostulacion extends ViewRecord
{
    protected static string $resource = PostulacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('observacionesEntrevista')
                ->label('Registrar entrevista')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('info')
                ->visible(function () {
                    $user = auth()->user();

                    return $user?->hasAnyRole(['coordinador', 'gerente'])
                        && ($this->record?->estado === 'Entrevista');
                })
                ->modalHeading('Observaciones de la entrevista')
                ->modalDescription('Este campo es interno (solo coordinación y gerencia).')
                ->modalSubmitActionLabel('Guardar observaciones')
                ->form([
                    Textarea::make('observaciones_entrevista')
                        ->label('Observaciones')
                        ->rows(8)
                        ->maxLength(10000)
                        ->default(fn () => $this->record?->observaciones_entrevista)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'observaciones_entrevista' => $data['observaciones_entrevista'],
                    ]);

                    Notification::make()
                        ->title('Observaciones guardadas')
                        ->success()
                        ->send();
                }),

            // Mantén acciones existentes si las tienes (ej: delete)
            // Actions\DeleteAction::make(),
        ];
    }
}