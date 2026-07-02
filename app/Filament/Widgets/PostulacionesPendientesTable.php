<?php

namespace App\Filament\Widgets;

use App\Models\Postulacion;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PostulacionesPendientesTable extends BaseWidget
{
    protected static ?string $heading = 'Postulaciones recientes';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Postulacion::query()
            ->orderByDesc('created_at');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('#')
                ->sortable(),

            Tables\Columns\TextColumn::make('estudiante_nombre')
                ->label('Postulante')
                ->searchable()
                ->limit(45)
                ->tooltip(fn ($record) => $record->estudiante_nombre)
                ->wrap(false)
                ->extraAttributes([
                    'class' => 'max-w-[300px] truncate',
                ]),

            Tables\Columns\TextColumn::make('documento_identidad')
                ->label('Documento')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->limit(20)
                ->wrap(false),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Fecha registro')
                ->dateTime('d/m/Y H:i')
                ->timezone('America/Bogota')
                ->sortable(),

            Tables\Columns\TextColumn::make('estado')
                ->label('Estado')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'Pendiente aprobación gerencia' => 'Pend. gerencia',
                    default => $state,
                })
                ->color(fn (string $state): string => match ($state) {
                    'Postulado', 'Pendiente' => 'warning',
                    'En estudio' => 'info',
                    'Pendiente aprobación gerencia' => 'primary',
                    'Aprobado' => 'success',
                    'Rechazado' => 'danger',
                    'Cancelado' => 'gray',
                    default => 'gray',
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('estadoActualizadoPor.name')
                ->label('Último cambio por')
                ->placeholder('—')
                ->sortable()
                ->searchable()
                ->limit(25)
                ->wrap(false)
                ->extraAttributes([
                    'class' => 'max-w-[200px] truncate',
                ]),

            Tables\Columns\TextColumn::make('estado_actualizado_en')
                ->label('Fecha cambio')
                ->dateTime('d/m/Y H:i')
                ->timezone('America/Bogota')
                ->sortable()
                ->placeholder('—'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('ver_resumen_gerencia')
                ->label('Ver')
                ->icon('heroicon-o-eye')
                ->iconButton()
                ->tooltip('Ver resumen de la postulación')
                ->color('gray')
                ->modalHeading(fn (Postulacion $record) => 'Resumen de postulación - ' . $record->estudiante_nombre)
                ->modalWidth('7xl')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Cerrar')
                ->modalContent(fn (Postulacion $record) => view('filament.postulaciones.resumen-gerencia', [
                    'postulacion' => $record,
                ])),
        ];
    }
}