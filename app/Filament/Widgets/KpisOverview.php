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
        $becasTotal      = Postulacion::query()->count();
        $becasPendiente  = Postulacion::query()->where('estado', 'Pendiente')->count();
        $becasEntrevista = Postulacion::query()->where('estado', 'Entrevista')->count();

        $usuariosTotal = User::query()->count();

        // ✅ Kits (si tienes modelo Kit). Si NO existe, queda en 0.
        $kitsTotal = class_exists(\App\Models\Kit::class)
            ? \App\Models\Kit::query()->count()
            : 0;

        return [
            Stat::make('Becas (Total)', $becasTotal)
                ->description("Pendiente: {$becasPendiente} · Entrevista: {$becasEntrevista}")
                ->color('primary'),

            Stat::make('Kits', $kitsTotal)
                ->description('Total registrados')
                ->color('warning'),

            Stat::make('Usuarios', $usuariosTotal)
                ->description('Total en el sistema')
                ->color('success'),
        ];
    }
}
