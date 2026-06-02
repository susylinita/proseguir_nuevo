<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Query base para reutilizar en listado y contadores
        $postulacionesQuery = Postulacion::where('user_id', $userId);

        $postulaciones = (clone $postulacionesQuery)
            ->latest()
            ->get();

        // Contadores para los widgets
        $counts = [
            'total' => (clone $postulacionesQuery)->count(),
            'postulado' => (clone $postulacionesQuery)->where('estado', 'Postulado')->count(),
            'en_estudio' => (clone $postulacionesQuery)->where('estado', 'En estudio')->count(),
            'aprobado' => (clone $postulacionesQuery)->where('estado', 'Aprobado')->count(),
            'rechazado' => (clone $postulacionesQuery)->where('estado', 'Rechazado')->count(),
            'cancelado' => (clone $postulacionesQuery)->where('estado', 'Cancelado')->count(),
        ];

        $ultima = $postulaciones->first();

        if ($ultima) {
            $ultima->load([
                'historicoEstados' => fn ($q) => $q->orderBy('cambiado_en'),
            ]);
        }

        // Documentos pendientes en la última postulación
        $pendientes = [];

        if ($ultima) {
            if ($ultima->tipo_postulacion === 'renovacion') {
                if (! $ultima->anexo_certificado_notas) {
                    $pendientes[] = 'Certificado de notas';
                }

                if (! $ultima->anexo_recibo_matricula) {
                    $pendientes[] = 'Recibo de matrícula';
                }

                if ($ultima->cuenta_actualizada && ! $ultima->anexo_certificado_bancario) {
                    $pendientes[] = 'Certificado bancario';
                }
            } else {
                if (! $ultima->anexo_doc_identidad) {
                    $pendientes[] = 'Documento de identidad';
                }

                if (! $ultima->anexo_foto_documento) {
                    $pendientes[] = 'Foto tipo documento';
                }

                if (! $ultima->anexo_certificado_bancario) {
                    $pendientes[] = 'Certificado bancario';
                }

                if (! $ultima->pdf_notas) {
                    $pendientes[] = 'PDF de notas';
                }

                if (! $ultima->pdf_matricula) {
                    $pendientes[] = 'PDF de matrícula';
                }
            }
        }

        return view(
            'student.postulaciones.dashboard',
            compact('postulaciones', 'ultima', 'pendientes', 'counts')
        );
    }
}