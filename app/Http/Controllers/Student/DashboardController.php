<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;

class DashboardController extends Controller
{
    public function index()
{
    $userId = auth()->id();

    $postulaciones = Postulacion::where('user_id', $userId)
        ->latest()
        ->get();

    // 📊 Contadores para los widgets
    $counts = [
        'total' => $postulaciones->count(),
        'pendiente' => $postulaciones->where('estado', 'Pendiente')->count(),
        'preseleccionado' => $postulaciones->where('estado', 'Preseleccionado')->count(),
        'aprobado' => $postulaciones->where('estado', 'Aprobado')->count(),
        'rechazado' => $postulaciones->where('estado', 'Rechazado')->count(),
    ];

    $ultima = $postulaciones->first();

    if ($ultima) {
        $ultima->load([
            'historicoEstados' => fn ($q) => $q->orderBy('cambiado_en')
        ]);
    }

    // 📄 Documentos pendientes en la última postulación
    $pendientes = [];
    if ($ultima) {
        if (!$ultima->pdf_notas) $pendientes[] = 'PDF de notas';
        if (!$ultima->pdf_matricula) $pendientes[] = 'PDF de matrícula';
    }

    return view(
        'student.postulaciones.dashboard',
        compact('postulaciones', 'ultima', 'pendientes', 'counts')
    );
}

}
