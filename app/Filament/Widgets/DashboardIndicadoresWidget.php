<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Postulacion;
// cambia este modelo por el tuyo real si el nombre no coincide
use App\Models\KitEscolar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardIndicadoresWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalPostulaciones = Postulacion::count();
        $postulados = Postulacion::where('estado', 'Postulado')->count();
        $enEstudio = Postulacion::where('estado', 'En estudio')->count();
        $pendGerencia = Postulacion::where('estado', 'Pendiente aprobación gerencia')->count();

        return [
            Stat::make('Becas (Total)', $totalPostulaciones)
                ->description("Postulado: {$postulados} · En estudio: {$enEstudio} · Pend. gerencia: {$pendGerencia}")
                ->icon('heroicon-o-academic-cap')
                ->extraAttributes([
                    'class' => 'fp-stat-card fp-stat-card--blue',
                ]),

            Stat::make('Kits', class_exists(KitEscolar::class) ? KitEscolar::count() : 0)
                ->description('Total registrados')
                ->icon('heroicon-o-gift')
                ->extraAttributes([
                    'class' => 'fp-stat-card fp-stat-card--orange',
                ]),

            Stat::make('Usuarios', User::count())
                ->description('Total en el sistema')
                ->icon('heroicon-o-users')
                ->extraAttributes([
                    'class' => 'fp-stat-card fp-stat-card--green',
                ]),
        ];
    }
}