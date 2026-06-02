<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?string $navigationGroup = 'Administración';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Datos de acceso')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
    ->label('Correo electrónico')
    ->email()
    ->nullable()
    ->unique(ignoreRecord: true)
    ->maxLength(255),

Forms\Components\Select::make('tipo_documento')
    ->label('Tipo de documento')
    ->options([
        'CC' => 'Cédula de ciudadanía',
        'TI' => 'Tarjeta de identidad',
        'CE' => 'Cédula de extranjería',
        'PAS' => 'Pasaporte',
        'RC' => 'Registro civil',
    ])
    ->required()
    ->searchable(),

Forms\Components\TextInput::make('cedula')
    ->label('Número de documento / Usuario')
    ->required()
    ->unique(ignoreRecord: true)
    ->maxLength(30),

                    Forms\Components\TextInput::make('password')
                        ->label('Clave')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->maxLength(255),

                    Forms\Components\Select::make('portal')
                        ->label('Portal')
                        ->options([
                            'postulantes' => 'Postulantes',
                            'kits' => 'Kits',
                            'admin' => 'Administrador',
                        ])
                        ->required(),

                    Forms\Components\CheckboxList::make('roles')
                        ->label('Rol')
                        ->relationship('roles', 'name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => match ($record->name) {
                            'admin' => 'Administrador',
                            'coordinacion' => 'Coordinación',
                            'gerencia' => 'Gerencia',
                            'postulante' => 'Postulante / Becado',
                            default => ucfirst($record->name),
                        })
                        ->required()
                        ->columns(2)
                        ->columnSpanFull(),

                ])
                ->columns(2),

            Forms\Components\Section::make('Control académico de beca')
                ->schema([
                    Forms\Components\Toggle::make('becas_bloqueado')
                        ->label('Suspender beca por promedio')
                        ->helperText('Active esta opción cuando el becario entregó los documentos requeridos, pero no cumple el promedio académico mínimo. La suspensión es temporal y podrá levantarse cuando recupere el promedio.'),

                    Forms\Components\Textarea::make('becas_bloqueado_motivo')
                        ->label('Motivo de suspensión')
                        ->placeholder('Ejemplo: El becario entregó documentos, pero no cumple el promedio académico requerido para continuar activo.')
                        ->rows(3)
                        ->columnSpanFull()
                        ->visible(fn ($get) => $get('becas_bloqueado')),
                ])
                ->columns(2),

            Forms\Components\Section::make('Permisos internos')
                ->schema([
                    Forms\Components\Toggle::make('is_admin')
                        ->label('Administrador interno'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cedula')
                    ->label('Usuario / Cédula')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo_documento')
                    ->label('Tipo doc.')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('portal')
                    ->label('Portal')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge(),

                Tables\Columns\IconColumn::make('becas_bloqueado')
                    ->label('Beca suspendida')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}