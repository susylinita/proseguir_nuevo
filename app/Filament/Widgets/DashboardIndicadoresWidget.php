<?php

namespace App\Filament\Widgets;

use App\Models\Postulacion;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardIndicadoresWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalPostulaciones = Postulacion::query()->count();

        $postulados = Postulacion::query()
            ->whereIn('estado', ['Postulado', 'Pendiente'])
            ->count();

        $enEstudio = Postulacion::query()
            ->where('estado', 'En estudio')
            ->count();

        $pendGerencia = Postulacion::query()
            ->where('estado', 'Pendiente aprobación gerencia')
            ->count();

        $aprobadas = Postulacion::query()
            ->where('estado', 'Aprobado')
            ->count();

        $kitsTotal = class_exists(\App\Models\KitEscolar::class)
            ? \App\Models\KitEscolar::query()->count()
            : 0;

        return [
            Stat::make('Becas (Total)', $totalPostulaciones)
                ->description("Postulado: {$postulados} · En estudio: {$enEstudio} · Pend. gerencia: {$pendGerencia} · Aprobadas: {$aprobadas}")
                ->icon('heroicon-o-academic-cap')
                ->extraAttributes([
                    'class' => 'fp-stat-card fp-stat-card--blue',
                ]),

            Stat::make('Kits', $kitsTotal)
                ->description('Total registrados')
                ->icon('heroicon-o-gift')
                ->extraAttributes([
                    'class' => 'fp-stat-card fp-stat-card--orange',
                ]),

            Stat::make('Usuarios', User::query()->count())
                ->description('Total en el sistema')
                ->icon('heroicon-o-users')
                ->extraAttributes([
                    'class' => 'fp-stat-card fp-stat-card--green',
                ]),
        ];
    }
}