<?php

namespace App\Filament\Resources\PostulacionResource\Pages;

use App\Filament\Resources\PostulacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostulacion extends EditRecord
{
    protected static string $resource = PostulacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['estado'] ?? null) !== ($this->record->estado ?? null)) {
            $data['estado_actualizado_por'] = auth()->id();
            $data['estado_actualizado_en'] = now();
        }

        return $data;
    }
}
