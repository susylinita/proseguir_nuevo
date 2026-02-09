<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KitEscolarResource\Pages;
use App\Filament\Resources\KitEscolarResource\RelationManagers;
use App\Models\KitEscolar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;

class KitEscolarResource extends Resource
{
    protected static ?string $model = KitEscolar::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift'; // Un regalo o maletín

    protected static ?string $navigationLabel = 'Kits Escolares';
    protected static ?string $modelLabel = 'Kit Escolar';
    protected static ?string $pluralModelLabel = 'Kits Escolares';

    protected static ?int $navigationSort = 2; // El número 1 sería para Postulaciones

    public static function form(Form $form): Form
    
{
    return $form
        ->schema([
            Forms\Components\Section::make('Información de la Entrega')
                ->description('Detalles del kit escolar entregado al estudiante')
                ->schema([
                    Forms\Components\TextInput::make('nombre_estudiante')
                        ->label('Nombre del Estudiante')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('grado_escolar')
                        ->label('Grado')
                        ->options([
                            'Primaria' => 'Primaria',
                            'Bachillerato' => 'Bachillerato',
                        ])
                        ->required(),

                    Forms\Components\Select::make('tipo_kit')
                        ->label('Tipo de Kit')
                        ->options([
                            'Kit A (Básico)' => 'Kit A (Básico)',
                            'Kit B (Completo)' => 'Kit B (Completo)',
                            'Mochila sola' => 'Mochila sola',
                        ])
                        ->required(),

                    Forms\Components\DatePicker::make('fecha_entrega')
                        ->label('Fecha de Entrega')
                        ->default(now()) // Pone la fecha de hoy por defecto
                        ->required(),

                    Forms\Components\Textarea::make('observaciones')
                        ->label('Observaciones')
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
}

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Aquí definimos qué ver en la lista
            Tables\Columns\TextColumn::make('nombre_estudiante')
                ->label('Estudiante')
                ->searchable() // Permite buscar por nombre
                ->sortable(),

            Tables\Columns\TextColumn::make('grado_escolar')
                ->label('Grado')
                ->badge() // Lo hace ver como una etiqueta
                ->color('info'),

            Tables\Columns\TextColumn::make('tipo_kit')
                ->label('Kit Entregado'),

            Tables\Columns\TextColumn::make('fecha_entrega')
                ->label('Fecha')
                ->date('d/m/Y') // Formato de fecha latino
                ->sortable(),

            Tables\Columns\TextColumn::make('observaciones')
                ->label('Observaciones')
                ->limit(30) // Corta el texto a 30 caracteres para que no ocupe mucho espacio
                ->tooltip(fn (Model $record): string => $record->observaciones ?? '') // Muestra el texto completo al pasar el ratón
                ->placeholder('Sin notas'), // Si está vacío, muestra esto en gris
        ])
        ->filters([
            // Aquí puedes añadir filtros por grado más adelante
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])

        ->recordUrl(
            fn (Model $record): string => Pages\ViewKitEscolar::getUrl([$record->id]),
        )

        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])
        ->paginationPageOptions([10, 25, 50]);;
}

    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Infolists\Components\Section::make('Información del Kit Escolar')
                ->schema([
                    Infolists\Components\TextEntry::make('nombre_estudiante')
                        ->label('Estudiante'),
                    Infolists\Components\TextEntry::make('grado_escolar')
                        ->label('Grado'),
                    Infolists\Components\TextEntry::make('tipo_kit')
                        ->label('Tipo de Kit'),
                    Infolists\Components\TextEntry::make('fecha_entrega')
                        ->label('Fecha de Entrega')
                        ->date('d/m/Y'),
                ])->columns(2),

            Infolists\Components\Section::make('Documentación y Notas')
                ->schema([
                    // Reemplaza 'pdf_comprobante' por el nombre real de tu columna en la base de datos
                    Infolists\Components\TextEntry::make('pdf_comprobante') 
                        ->label('Documento PDF')
                        ->icon('heroicon-m-document-text')
                        ->color('primary')
                        ->formatStateUsing(fn () => '👁️ Hacer clic para ver PDF')
                        ->url(fn ($record) => $record->pdf_comprobante ? Storage::url($record->pdf_comprobante) : null, true)
                        ->visible(fn ($record) => $record->pdf_comprobante !== null),

                    Infolists\Components\TextEntry::make('observaciones')
                        ->label('Observaciones')
                        ->columnSpanFull(),
                ])->columns(2),
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
        'index' => Pages\ListKitEscolars::route('/'),
        'create' => Pages\CreateKitEscolar::route('/create'),
        'view' => Pages\ViewKitEscolar::route('/{record}'),
        'edit' => Pages\EditKitEscolar::route('/{record}/edit'),
    ];
    }
}
