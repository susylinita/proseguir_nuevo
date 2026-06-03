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
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de acceso')
                    ->description('Información principal para el ingreso del usuario al sistema.')
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
                            ->searchable()
                            ->native(false),

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
                            ->maxLength(255)
                            ->helperText('En edición, deje este campo vacío si no desea cambiar la clave.'),

                        Forms\Components\Select::make('portal')
                            ->label('Portal')
                            ->options([
                                'postulantes' => 'Postulantes',
                                'kits' => 'Kits',
                                'admin' => 'Administrador',
                            ])
                            ->required()
                            ->searchable()
                            ->native(false),

                        Forms\Components\CheckboxList::make('roles')
                            ->label('Rol')
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => match ($record->name) {
                                'admin' => 'Administrador',
                                'admin_panel' => 'Administrador panel',
                                'coordinacion' => 'Coordinación',
                                'coordinador' => 'Coordinador',
                                'gerencia' => 'Gerencia',
                                'gerente' => 'Gerente',
                                'postulante' => 'Postulante / Becado',
                                default => ucfirst($record->name),
                            })
                            ->required()
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Control académico de beca')
                    ->description('Permite suspender temporalmente la beca por incumplimiento académico.')
                    ->schema([
                        Forms\Components\Toggle::make('becas_bloqueado')
                            ->label('Suspender beca por promedio')
                            ->live()
                            ->helperText('Active esta opción cuando el becario entregó los documentos requeridos, pero no cumple el promedio académico mínimo.'),

                        Forms\Components\Textarea::make('becas_bloqueado_motivo')
                            ->label('Motivo de suspensión')
                            ->placeholder('Ejemplo: El becario entregó documentos, pero no cumple el promedio académico requerido para continuar activo.')
                            ->rows(3)
                            ->columnSpanFull()
                            ->visible(fn ($get) => (bool) $get('becas_bloqueado')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Permisos internos')
                    ->description('Control interno para usuarios con acceso administrativo.')
                    ->schema([
                        Forms\Components\Toggle::make('is_admin')
                            ->label('Administrador interno')
                            ->helperText('Active esta opción solo para usuarios que puedan ingresar al panel administrativo.'),
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
                    ->sortable()
                    ->limit(35)
                    ->tooltip(fn ($record) => $record->name),

                Tables\Columns\TextColumn::make('cedula')
                    ->label('Usuario / Cédula')
                    ->searchable()
                    ->sortable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable()
                    ->limit(38)
                    ->tooltip(fn ($record) => $record->email),

                Tables\Columns\TextColumn::make('portal')
                    ->label('Portal')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'postulantes' => 'Postulantes',
                        'kits' => 'Kits',
                        'admin' => 'Admin',
                        default => $state ? ucfirst($state) : 'Sin portal',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'postulantes' => 'info',
                        'kits' => 'warning',
                        'admin' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge()
                    ->separator(',')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'admin' => 'Administrador',
                        'admin_panel' => 'Admin panel',
                        'coordinacion' => 'Coordinación',
                        'coordinador' => 'Coordinador',
                        'gerencia' => 'Gerencia',
                        'gerente' => 'Gerente',
                        'postulante' => 'Postulante',
                        default => $state ? ucfirst($state) : 'Sin rol',
                    })
                    ->color('primary'),

                Tables\Columns\TextColumn::make('tipo_documento')
                    ->label('Tipo doc.')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('becas_bloqueado')
                    ->label('Beca susp.')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('becas_bloqueado_motivo')
                    ->label('Motivo suspensión')
                    ->limit(35)
                    ->tooltip(fn ($record) => $record->becas_bloqueado_motivo)
                    ->placeholder('Sin motivo')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('portal')
                    ->label('Portal')
                    ->options([
                        'postulantes' => 'Postulantes',
                        'kits' => 'Kits',
                        'admin' => 'Administrador',
                    ]),

                Tables\Filters\TernaryFilter::make('becas_bloqueado')
                    ->label('Beca suspendida'),

                Tables\Filters\TernaryFilter::make('is_admin')
                    ->label('Administrador interno'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-o-pencil-square')
                    ->iconButton()
                    ->tooltip('Editar usuario')
                    ->visible(fn ($record) => static::canEdit($record)),

                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-o-trash')
                    ->iconButton()
                    ->tooltip('Eliminar usuario')
                    ->visible(fn ($record) => static::canDelete($record))
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->hasRole('admin') ?? false),
                ]),
            ])
            ->emptyStateHeading('No hay usuarios registrados')
            ->emptyStateDescription('Cree el primer usuario para comenzar a gestionar accesos.')
            ->emptyStateIcon('heroicon-o-users');
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