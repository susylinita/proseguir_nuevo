<?php

namespace App\Filament\Resources\KitRegistroResource\Pages;

use App\Filament\Resources\KitRegistroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKitRegistro extends EditRecord
{
    protected static string $resource = KitRegistroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
