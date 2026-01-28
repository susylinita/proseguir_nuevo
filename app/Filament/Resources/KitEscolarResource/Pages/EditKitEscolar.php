<?php

namespace App\Filament\Resources\KitEscolarResource\Pages;

use App\Filament\Resources\KitEscolarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKitEscolar extends EditRecord
{
    protected static string $resource = KitEscolarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
