<?php

namespace App\Filament\Resources\KitRegistroResource\Pages;

use App\Filament\Resources\KitRegistroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKitRegistros extends ListRecords
{
    protected static string $resource = KitRegistroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
