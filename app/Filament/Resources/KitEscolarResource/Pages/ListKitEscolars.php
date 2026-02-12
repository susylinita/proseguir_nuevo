<?php

namespace App\Filament\Resources\KitEscolarResource\Pages;

use App\Filament\Resources\KitEscolarResource;
use App\Models\KitRegistro;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ListKitEscolars extends ListRecords
{
    protected static string $resource = KitEscolarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('descargarReporte')
                ->label('Descargar PDF')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {

                    $kits = KitRegistro::with('aprobador')->get();

                    $titulo = 'Reporte General - Kits Escolares';
                    $fecha = Carbon::now();

                    $pdf = Pdf::loadView(
                        'pdf.reporte-kits',
                        compact('kits', 'titulo', 'fecha')
                    )->setPaper('a4', 'landscape');

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'kits_general_' . now()->format('Ymd_His') . '.pdf'
                    );
                }),

        ];
    }
}
