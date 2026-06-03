<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminHeroWidget;
use App\Filament\Widgets\DashboardIndicadoresWidget;
use App\Filament\Widgets\PostulacionesPendientesTable;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Escritorio';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 1;


    public function getTitle(): string
    {
        return '';
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getHeaderWidgets(): array
    {
        return [
            AdminHeroWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        return [
            DashboardIndicadoresWidget::class,
            PostulacionesPendientesTable::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 12;
    }
}