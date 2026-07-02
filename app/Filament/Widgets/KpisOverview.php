<?php

namespace App\Filament\Widgets;

use App\Models\Postulacion;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KpisOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $becasTotal = Postulacion::query()->count();

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

        $usuariosTotal = User::query()->count();

        $kitsTotal = class_exists(\App\Models\KitEscolar::class)
            ? \App\Models\KitEscolar::query()->count()
            : 0;

        return [
            Stat::make('Becas (Total)', $becasTotal)
                ->description("Postulado: {$postulados} · En estudio: {$enEstudio} · Pend. gerencia: {$pendGerencia} · Aprobadas: {$aprobadas}")
                ->color('primary')
                ->icon('heroicon-o-academic-cap'),

            Stat::make('Kits', $kitsTotal)
                ->description('Total registrados')
                ->color('warning')
                ->icon('heroicon-o-gift'),

            Stat::make('Usuarios', $usuariosTotal)
                ->description('Total en el sistema')
                ->color('success')
                ->icon('heroicon-o-users'),
        ];
    }
}