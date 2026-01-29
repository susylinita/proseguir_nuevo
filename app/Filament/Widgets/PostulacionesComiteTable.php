<?php

namespace App\Filament\Widgets;

use App\Models\Postulacion;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PostulacionesComiteTable extends BaseWidget
{
    protected static ?string $heading = 'Postulaciones para comité (recientes / con pendientes)';

    protected function getTableQuery(): Builder
    {
        return Postulacion::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('#')
                ->sortable(),

            Tables\Columns\TextColumn::make('estudiante_nombre')
                ->label('Postulante')
                ->searchable(),

            Tables\Columns\TextColumn::make('tipo_postulacion')
                ->label('Tipo')
                ->badge()
                ->formatStateUsing(fn (?string $state): string => match ($state) {
                    'primer_semestre' => 'Primer semestre',
                    'otro_semestre'   => 'Otro semestre',
                    'renovacion'      => 'Renovación',
                    default           => $state ?? 'N/D',
                }),

            Tables\Columns\TextColumn::make('estado')
                ->label('Estado')
                ->badge()
                ->color(fn (?string $state): string => match ($state) {
                    'Aprobado'    => 'success',
                    'Entrevista'  => 'info',
                    'Rechazado'   => 'danger',
                    'Pendiente'   => 'warning',
                    default       => 'gray',
                }),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Actualizado')
                ->dateTime('Y-m-d H:i'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('ver')
                ->label('Ver')
                ->url(fn (Postulacion $record) => route('filament.admin.resources.postulacions.view', $record))
                ->openUrlInNewTab(),
        ];
    }
}
