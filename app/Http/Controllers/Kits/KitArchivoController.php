<?php

namespace App\Http\Controllers\Kits;

use App\Http\Controllers\Controller;
use App\Models\KitRegistro;
use Illuminate\Support\Facades\Storage;

class KitArchivoController extends Controller
{
    
    public function documento(KitRegistro $registro)
    {
        dd($registro->pdf_documento);
        // 🔒 Solo el dueño o admin/coordinador/gerente
        abort_unless(
            auth()->id() === $registro->user_id
            || auth()->user()->hasRole(['coordinador','gerente'])
            || auth()->user()->is_admin,
            403
        );

        abort_unless($registro->pdf_documento, 404);

        return response()->file(
            Storage::disk('public')->path($registro->pdf_documento),
            ['Content-Type' => 'application/pdf']
        );
    }

    public function certificado(KitRegistro $registro)
    {
        abort_unless(
            auth()->id() === $registro->user_id
            || auth()->user()->hasRole(['coordinador','gerente'])
            || auth()->user()->is_admin,
            403
        );

        abort_unless($registro->pdf_certificado, 404);

        return response()->file(
            Storage::disk('public')->path($registro->pdf_certificado),
            ['Content-Type' => 'application/pdf']
        );
    }
}
