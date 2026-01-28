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

        $ultima = Postulacion::where('user_id', $userId)
            ->latest()
            ->first();

        if ($ultima) {
            $ultima->load(['historicoEstados' => fn ($q) => $q->orderBy('cambiado_en')]);
        }

        // Documentos pendientes en la última postulación (si existe)
        $pendientes = [];
        if ($ultima) {
            if (!$ultima->pdf_notas) $pendientes[] = 'PDF de notas';
            if (!$ultima->pdf_matricula) $pendientes[] = 'PDF de matrícula';
        }

        return view('student.postulaciones.dashboard', compact('postulaciones', 'ultima', 'pendientes'));
    }
}
