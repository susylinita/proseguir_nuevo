<?php

namespace App\Filament\Resources\KitEscolarResource\Pages;

use App\Filament\Resources\KitEscolarResource;
use App\Models\KitEscolar; // Importa el modelo
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Barryvdh\DomPDF\Facade\Pdf; // Importa el generador de PDF

class ListKitEscolars extends ListRecords
{
    protected static string $resource = KitEscolarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
            // BOTÓN DE DESCARGAR REPORTE
            Actions\Action::make('descargarReporte')
                ->label('Descargar PDF')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $kits = KitEscolar::all(); // Trae a todos los estudiantes
                    
                    $pdf = Pdf::loadView('pdf.reporte-kits', [
                        'kits' => $kits,
                        'fecha' => now()->format('d/m/Y')
                    ]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, 'reporte-kits-' . now()->format('Y-m-d') . '.pdf');
                }),
        ];
    }
}