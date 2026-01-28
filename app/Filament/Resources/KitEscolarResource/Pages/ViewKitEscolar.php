<?php

namespace App\Filament\Resources\KitEscolarResource\Pages;

use App\Filament\Resources\KitEscolarResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKitEscolar extends ViewRecord
{
    protected static string $resource = KitEscolarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}