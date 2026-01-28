<?php

namespace App\Http\Controllers\Kits;

use App\Http\Controllers\Controller;
use App\Models\KitRegistro;

class KitDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $registros = KitRegistro::where('user_id', $userId)->latest()->get();

        $counts = [
            'total' => $registros->count(),
            'pendiente' => $registros->where('estado', 'Pendiente')->count(),
            'aprobado' => $registros->where('estado', 'Aprobado')->count(),
            'rechazado' => $registros->where('estado', 'Rechazado')->count(),
            'entregado' => $registros->where('estado', 'Entregado')->count(),
        ];

        return view('kits.dashboard', compact('registros', 'counts'));
    }
}
