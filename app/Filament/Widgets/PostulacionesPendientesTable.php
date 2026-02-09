<?php

namespace App\Filament\Widgets;

use App\Models\Postulacion;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PostulacionesPendientesTable extends BaseWidget
{
    protected static ?string $heading = 'Postulaciones recientes (Pendiente / Entrevista)';
    protected static ?int $sort = 2;

    protected function getTableQuery(): Builder
    {
        return Postulacion::query()
            ->whereIn('estado', ['Pendiente', 'Entrevista'])
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
            Tables\Columns\TextColumn::make('estudiante_nombre')->label('Postulante')->searchable(),
            Tables\Columns\TextColumn::make('documento_identidad')
                ->label('Documento')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('estado')
                ->badge()
                ->color(fn (string $state) => match ($state) {
                    'Entrevista' => 'info',
                    'Pendiente'  => 'warning',
                    default      => 'gray',
                })
                ->sortable(),

                Tables\Columns\TextColumn::make('estadoActualizadoPor.name')
                    ->label('Último cambio por')
                    ->placeholder('—')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('estado_actualizado_en')
                    ->label('Fecha cambio')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->placeholder('—'),
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
