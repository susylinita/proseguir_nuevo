<?php

namespace App\Filament\Widgets;

use App\Models\Postulacion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostulacionesComiteStats extends BaseWidget
{
    protected function getStats(): array
    {
        $q = Postulacion::query();

        $total = (clone $q)->count();

        $pendiente = (clone $q)->where('estado', 'Pendiente')->count();
        $entrevista = (clone $q)->where('estado', 'Entrevista')->count();
        $aprobado = (clone $q)->where('estado', 'Aprobado')->count();
        $rechazado = (clone $q)->where('estado', 'Rechazado')->count();

        $primer = (clone $q)->where('tipo_postulacion', 'primer_semestre')->count();
        $otro = (clone $q)->where('tipo_postulacion', 'otro_semestre')->count();
        $reno = (clone $q)->where('tipo_postulacion', 'renovacion')->count();

        // Pendientes de documentos (según tu lógica)
        $pendientesDocs = (clone $q)->where(function ($qq) {
            $qq->where('tipo_postulacion', 'renovacion')
                ->where(function ($r) {
                    $r->whereNull('anexo_certificado_notas')->orWhere('anexo_certificado_notas', '')
                      ->orWhereNull('anexo_recibo_matricula')->orWhere('anexo_recibo_matricula', '');
                })
            ->orWhere(function ($n) {
                $n->whereIn('tipo_postulacion', ['primer_semestre', 'otro_semestre'])
                  ->where(function ($x) {
                      $x->whereNull('anexo_doc_identidad')->orWhere('anexo_doc_identidad', '')
                        ->orWhereNull('anexo_foto_documento')->orWhere('anexo_foto_documento', '')
                        ->orWhereNull('anexo_certificado_bancario')->orWhere('anexo_certificado_bancario', '')
                        ->orWhereNull('promedio_carrera');
                  });
            });
        })->count();

        return [
            Stat::make('Total', $total),

            Stat::make('Pendientes', $pendiente)->color('warning'),
            Stat::make('Entrevista', $entrevista)->color('info'),
            Stat::make('Aprobadas', $aprobado)->color('success'),
            Stat::make('Rechazadas', $rechazado)->color('danger'),

            Stat::make('Primer semestre', $primer),
            Stat::make('Otro semestre', $otro),
            Stat::make('Renovación', $reno),

            Stat::make('Pendientes de documentos', $pendientesDocs)->color($pendientesDocs > 0 ? 'warning' : 'success'),
        ];
    }
}
