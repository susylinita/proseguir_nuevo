<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\AdminHero::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\KpisOverview::class,
            \App\Filament\Widgets\PostulacionesPendientesTable::class,
        ];
    }

    // 👇 ESTE es el método correcto (no getColumns)
    public function getWidgetsColumns(): int|array
    {
        return 12;
    }

    public function getColumns(): int | string |array
    {
        return 1;
    }
}
