<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KitEscolarResource\Pages;
use App\Models\KitRegistro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
 use Filament\Infolists\Components\TextEntry;

class KitEscolarResource extends Resource
{
    protected static ?string $model = KitRegistro::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationLabel = 'Kits Escolares';
    protected static ?string $modelLabel = 'Kit Escolar';
    protected static ?string $pluralModelLabel = 'Kits Escolares';
    protected static ?int $navigationSort = 2;

    /* ======================================================
     | FORM
     ======================================================*/
    public static function form(Form $form): Form
    {
        return $form->schema([

                Forms\Components\Select::make('user_id')
                    ->label('Postulante')
                    ->relationship('user', 'name') // o 'email'
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

            Forms\Components\Section::make('Información del colaborador')
                ->schema([
                    Forms\Components\TextInput::make('colaborador_nombre')
                        ->label('Nombre completo')
                        ->required(),

                    Forms\Components\TextInput::make('colaborador_documento')
                        ->label('Documento')
                        ->required(),

                    Forms\Components\TextInput::make('linea_negocio')
                        ->label('Línea de negocio')
                        ->required(),

                    Forms\Components\TextInput::make('area')
                        ->label('Área')
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Información del niño')
                ->schema([
                    Forms\Components\TextInput::make('nino_nombre')
                        ->label('Nombre completo')
                        ->required(),

                    Forms\Components\TextInput::make('nino_documento')
                        ->label('Documento')
                        ->required(),

                    Forms\Components\TextInput::make('edad')
                        ->label('Edad')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('grado')
                        ->label('Grado')
                        ->required(),

                    Forms\Components\TextInput::make('institucion')
                        ->label('Institución')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(2),

                Forms\Components\Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->rows(3)
                    ->columnSpanFull(),
        ]);
    }

    /* ======================================================
     | TABLE (LISTADO)
     ======================================================*/
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                 Tables\Columns\TextColumn::make('user.name')
                    ->label('Postulante')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('colaborador_nombre')
                    ->label('Colaborador')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nino_nombre')
                    ->label('Niño')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('grado')
                    ->label('Grado')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('institucion')
                    ->label('Institución')
                    ->limit(25),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha registro')
                    ->dateTime('d/m/Y')
                    ->sortable(),

                    Tables\Columns\TextColumn::make('estado')
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'Pendiente' => 'warning',
                            'Aprobado' => 'success',
                            'Rechazado' => 'danger',
                            'Entregado' => 'primary',
                        }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('aprobar')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->estado === 'Pendiente')
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        $record->update([
                            'estado' => 'Aprobado',
                            'aprobado_por' => Auth::id(),
                            'fecha_aprobacion' => now(),
                        ]);

                    }),

                    Tables\Actions\Action::make('rechazar')
                        ->label('Rechazar')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => $record->estado === 'Pendiente')
                        ->form([
                            Forms\Components\Textarea::make('observaciones')
                                ->label('Motivo del rechazo')
                                ->required()
                                ->rows(3),
                        ])
                        ->action(function ($record, array $data) {
                            $record->update([
                                'estado' => 'Rechazado',
                                'observaciones' => $data['observaciones'],
                            ]);
                        }),

                        Tables\Actions\Action::make('entregar')
                            ->label('Marcar entregado')
                            ->icon('heroicon-o-truck')
                            ->color('primary')
                            ->visible(fn ($record) => $record->estado === 'Aprobado')
                            ->requiresConfirmation()
                            ->action(function ($record) {
                                $record->update([
                                    'estado' => 'Entregado',
                                ]);
                            }),


            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /* ======================================================
     | VIEW (SHOW)
     ======================================================*/
    

    public static function infolist(Infolist $infolist): Infolist
    
    {
        
        return $infolist->schema([

            Infolists\Components\Section::make('Información del colaborador')
                ->schema([
                    Infolists\Components\TextEntry::make('colaborador_nombre')
                        ->label('Nombre'),

                    Infolists\Components\TextEntry::make('colaborador_documento')
                        ->label('Documento'),

                    Infolists\Components\TextEntry::make('linea_negocio')
                        ->label('Línea de negocio'),

                    Infolists\Components\TextEntry::make('area')
                        ->label('Área'),
                ])
                ->columns(2),

            Infolists\Components\Section::make('Información del niño')
                ->schema([
                    Infolists\Components\TextEntry::make('nino_nombre')
                        ->label('Nombre'),

                    Infolists\Components\TextEntry::make('nino_documento')
                        ->label('Documento'),

                    Infolists\Components\TextEntry::make('edad')
                        ->label('Edad'),

                    Infolists\Components\TextEntry::make('grado')
                        ->label('Grado'),

                    Infolists\Components\TextEntry::make('institucion')
                        ->label('Institución'),

                    Infolists\Components\TextEntry::make('observaciones')
                        ->label(fn ($record) => 
                            $record->estado === 'Rechazado'
                                ? 'Motivo del rechazo'
                                : 'Observaciones'
                        )
                        ->columnSpanFull()
                        ->visible(fn ($record) => filled($record->observaciones))
                        ->extraAttributes(fn ($record) => [
                            'class' => $record->estado === 'Rechazado'
                                ? 'bg-red-50 border border-red-200 p-4 rounded-lg'
                                : 'bg-gray-50 border border-gray-200 p-4 rounded-lg'
                        ]),

                        
                ])
                ->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKitEscolars::route('/'),
            'create' => Pages\CreateKitEscolar::route('/create'),
            'view' => Pages\ViewKitEscolar::route('/{record}'),
            'edit' => Pages\EditKitEscolar::route('/{record}/edit'),
        ];
    }
}
