<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KitRegistroResource\Pages;
use App\Filament\Resources\KitRegistroResource\RelationManagers;
use App\Models\KitRegistro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class KitRegistroResource extends Resource
{
    protected static ?string $model = KitRegistro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Section::make('Datos del niño')
            ->schema([
                Forms\Components\TextInput::make('nino_nombre')
                    ->label('Nombre del niño')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('nino_documento')
                    ->label('Documento')
                    ->maxLength(80),

                Forms\Components\DatePicker::make('nino_fecha_nacimiento')
                    ->label('Fecha de nacimiento'),

                Forms\Components\TextInput::make('institucion')
                    ->label('Institución')
                    ->maxLength(255),

                Forms\Components\TextInput::make('grado')
                    ->label('Grado')
                    ->maxLength(50),
            ])
            ->columns(2),

        Forms\Components\Section::make('Soportes')
            ->schema([
                Forms\Components\FileUpload::make('pdf_documento')
                    ->label('Documento de identidad (PDF)')
                    ->disk('public')
                    ->directory('kits/documento')
                    ->openable()
                    ->downloadable(),

                Forms\Components\FileUpload::make('pdf_certificado')
                    ->label('Certificado (PDF)')
                    ->disk('public')
                    ->directory('kits/certificado')
                    ->openable()
                    ->downloadable(),
            ])
            ->columns(2),

        Forms\Components\Section::make('Gestión interna')
            ->schema([
                Forms\Components\Select::make('estado')
                    ->options([
                        'Pendiente' => 'Pendiente',
                        'Aprobado' => 'Aprobado',
                        'Rechazado' => 'Rechazado',
                        'Entregado' => 'Entregado',
                    ])
                    ->required(),
            ]),
    ]);
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nino_nombre')->searchable()->sortable()->label('Niño'),
                Tables\Columns\TextColumn::make('user.name')->label('Acudiente')->searchable(),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Aprobado' => 'success',
                        'Pendiente' => 'warning',
                        'Rechazado' => 'danger',
                        'Entregado' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('Y-m-d H:i')->sortable()->label('Actualizado'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('aprobar')
                    ->label('Aprobar')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => in_array($record->estado, ['Pendiente']))
                    ->action(function ($record) {
                        $record->update(['estado' => 'Aprobado']);
                        Notification::make()->title('Registro aprobado')->success()->send();
                    }),

                Tables\Actions\Action::make('rechazar')
                    ->label('Rechazar')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => in_array($record->estado, ['Pendiente']))
                    ->action(function ($record) {
                        $record->update(['estado' => 'Rechazado']);
                        Notification::make()->title('Registro rechazado')->danger()->send();
                    }),

                Tables\Actions\Action::make('entregar')
                    ->label('Marcar entregado')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->estado === 'Aprobado')
                    ->action(function ($record) {
                        $record->update(['estado' => 'Entregado']);
                        Notification::make()->title('Kit marcado como entregado')->success()->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKitRegistros::route('/'),
            'create' => Pages\CreateKitRegistro::route('/create'),
            'edit' => Pages\EditKitRegistro::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user?->hasRole('coordinador') || $user?->hasRole('gerente') || ($user?->is_admin ?? false);
    }

}
