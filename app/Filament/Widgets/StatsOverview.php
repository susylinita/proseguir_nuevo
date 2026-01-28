<?php

namespace App\Filament\Widgets;

use App\Models\Postulacion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Postulaciones', Postulacion::count())
                ->description('Estudiantes inscritos')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Candidatos Aptos', Postulacion::where('promedio_universitario', '>=', 3.8)
                ->where('puntaje_saber', '>=', 300)
                ->count())
                ->description('Cumplen requisitos (Manual)')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Becas Aprobadas', Postulacion::where('estado', 'Aprobado')->count())
                ->description('Listos para desembolso')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('primary'),
        ];
    }
}