<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostulacionResource\Pages;
use App\Models\Postulacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class PostulacionResource extends Resource
{
    protected static ?string $model = Postulacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    /**
     * Permisos de alto nivel en Filament (opcional pero recomendado)
     * - Solo coordinador y gerente deberían acceder al panel (ya lo controlas con canAccessPanel en User)
     */
    public static function canCreate(): bool
    {
        // Admin puede crear registros desde Filament
        return auth()->user()?->hasAnyRole(['coordinador', 'gerente']) ?? false;
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        if (! $user) return false;

        // Nadie edita si ya está aprobada (recomendado)
        if ($record?->estado === 'Aprobado') {
            return false;
        }

        return $user->hasAnyRole(['coordinador', 'gerente']);
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        if (! $user) return false;

        // Por seguridad: solo gerente puede eliminar (puedes cambiarlo)
        return $user->hasRole('gerente');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Datos del Postulante')
                ->schema([
                    Forms\Components\TextInput::make('estudiante_nombre')
                        ->label('Nombre Completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('estudiante_email')
                        ->label('Correo Electrónico')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('puntaje_saber')
                        ->label('Puntaje Saber 11')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('promedio_universitario')
                        ->label('Promedio Acumulado')
                        ->numeric()
                        ->step(0.1)
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Documentación PDF')
                ->schema([
                    Forms\Components\FileUpload::make('pdf_notas')
                        ->label('Certificado de Notas')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('postulaciones/notas')
                        ->preserveFilenames()
                        ->openable()
                        ->required(),

                    Forms\Components\FileUpload::make('pdf_matricula')
                        ->label('Recibo de Matrícula')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('postulaciones/matriculas')
                        ->preserveFilenames()
                        ->openable()
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Gestión Interna')
                ->schema([
                    /**
                     * Estado controlado por rol:
                     * - Coordinador: Pendiente, Preseleccionado, Rechazado
                     * - Gerente: Pendiente, Preseleccionado, Aprobado, Rechazado
                     */
                    Forms\Components\Select::make('estado')
                        ->label('Estado')
                        ->options(function () {
                            $user = auth()->user();

                            if ($user?->hasRole('gerente')) {
                                return [
                                    'Pendiente' => 'Pendiente',
                                    'Preseleccionado' => 'Preseleccionado',
                                    'Aprobado' => 'Aprobado',
                                    'Rechazado' => 'Rechazado',
                                ];
                            }

                            if ($user?->hasRole('coordinador')) {
                                return [
                                    'Pendiente' => 'Pendiente',
                                    'Preseleccionado' => 'Preseleccionado',
                                    'Rechazado' => 'Rechazado',
                                ];
                            }

                            return [];
                        })
                        ->required()
                        ->disabled(fn ($record) => $record && $record->estado === 'Aprobado')
                        ->helperText('El estado depende del rol (coordinador/gerente).'),

                    Forms\Components\Textarea::make('perfil_descriptivo')
                        ->label('Perfil descriptivo (coordinación)')
                        ->rows(4)
                        ->maxLength(5000)
                        ->helperText('Este campo lo diligencia coordinación (y es visible para el estudiante).')
                        ->disabled(function () {
                            // Si quisieras que gerente no lo edite, cámbialo aquí
                            return ! (auth()->user()?->hasAnyRole(['coordinador', 'gerente']) ?? false);
                        }),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estudiante_nombre')
                    ->label('Postulante')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('estudiante_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('promedio_universitario')
                    ->label('Promedio')
                    ->badge()
                    ->color(fn ($state) => $state >= 3.8 ? 'success' : 'danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('puntaje_saber')
                    ->label('Saber 11')
                    ->badge()
                    ->color(fn ($state) => $state >= 300 ? 'success' : 'danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pdf_notas')
                    ->label('Notas')
                    ->formatStateUsing(fn () => 'Abrir')
                    ->url(fn ($record) => $record->pdf_notas ? asset('storage/' . $record->pdf_notas) : null)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => !empty($record->pdf_notas))
                    ->color('primary'),

                Tables\Columns\TextColumn::make('pdf_matricula')
                    ->label('Matrícula')
                    ->formatStateUsing(fn () => 'Abrir')
                    ->url(fn ($record) => $record->pdf_matricula ? asset('storage/' . $record->pdf_matricula) : null)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => !empty($record->pdf_matricula))
                    ->color('primary'),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aprobado' => 'success',
                        'Preseleccionado' => 'warning',
                        'Rechazado' => 'danger',
                        'Pendiente' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                // Auditoría (si existen esos campos)
                Tables\Columns\TextColumn::make('estado_actualizado_en')
                    ->label('Último cambio')
                    ->dateTime('Y-m-d H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('estado_actualizado_por')
                    ->label('Actualizó (ID)')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('Cumple Requisitos')
                    ->query(fn (Builder $query) => $query
                        ->where('promedio_universitario', '>=', 3.8)
                        ->where('puntaje_saber', '>=', 300)
                    )
                    ->label('Candidatos Aptos (Manual)'),
            ])
            ->actions([
                // Coordinador: Preseleccionar (solo si Pendiente)
                Tables\Actions\Action::make('preseleccionar')
                    ->label('Preseleccionar')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn ($record) =>
                        auth()->user()?->hasRole('coordinador')
                        && $record->estado === 'Pendiente'
                    )
                    ->action(function ($record) {
                        $record->update(['estado' => 'Preseleccionado']);

                        Notification::make()
                            ->title('Postulación preseleccionada')
                            ->success()
                            ->send();
                    }),

                // Gerente: Aprobar (solo si Preseleccionado)
                Tables\Actions\Action::make('aprobar')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar aprobación')
                    ->visible(fn ($record) =>
                        auth()->user()?->hasRole('gerente')
                        && $record->estado === 'Preseleccionado'
                    )
                    ->action(function ($record) {
                        $record->update(['estado' => 'Aprobado']);

                        Notification::make()
                            ->title('Postulación aprobada')
                            ->success()
                            ->send();
                    }),

                // Coordinador o Gerente: Rechazar (si no está Aprobado)
                Tables\Actions\Action::make('rechazar')
                    ->label('Rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar rechazo')
                    ->visible(fn ($record) =>
                        auth()->user()?->hasAnyRole(['coordinador', 'gerente'])
                        && $record->estado !== 'Aprobado'
                        && $record->estado !== 'Rechazado'
                    )
                    ->action(function ($record) {
                        $record->update(['estado' => 'Rechazado']);

                        Notification::make()
                            ->title('Postulación rechazada')
                            ->danger()
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => static::canEdit($record)),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => static::canDelete($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->hasRole('gerente') ?? false),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Si luego quieres ver el historial como RelationManager, lo añadimos aquí.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostulacions::route('/'),
            'create' => Pages\CreatePostulacion::route('/create'),
            'view' => Pages\ViewPostulacion::route('/{record}'),
            'edit' => Pages\EditPostulacion::route('/{record}/edit'),
        ];
    }
}
