<?php

namespace App\Filament\Resources\KitEscolarResource\Pages;

use App\Filament\Resources\KitEscolarResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKitEscolar extends CreateRecord
{
    protected static string $resource = KitEscolarResource::class;

    // ESTA ES LA FUNCIÓN QUE DEBES AÑADIR:
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}