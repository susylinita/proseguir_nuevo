<?php

namespace App\Http\Controllers\Kits;

use App\Http\Controllers\Controller;
use App\Models\KitRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KitRegistroController extends Controller
{
    public function index()
    {
        $registros = KitRegistro::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('kits.registros.index', compact('registros'));
    }

    public function create()
    {
        return view('kits.registros.create');
    }

    public function store(Request $request)
    {
        // ✅ Validación (sin mimes/mimetypes por el MIME "octet-stream" en tu entorno)
        $pdfRules = ['nullable', 'file', 'max:5120'];

        $data = $request->validate([
            'colaborador_nombre' => 'required|string|max:255',
            'colaborador_documento' => 'required|string|max:50',
            'linea_negocio' => 'required|string|max:255',
            'area' => 'required|string|max:255',

            'nino_nombre' => 'required|string|max:255',
            'nino_documento' => 'required|string|max:50',
            'edad' => 'required|integer|min:1',
            'grado' => 'required|string|max:100',
            'institucion' => 'required|string|max:255',
        ]);

        // ✅ Validación manual por extensión
        foreach (['pdf_documento', 'pdf_certificado'] as $field) {
            if ($request->hasFile($field)) {
                $ext = strtolower($request->file($field)->getClientOriginalExtension());
                if ($ext !== 'pdf') {
                    return back()->withErrors([
                        $field => 'El archivo debe ser PDF (.pdf).',
                    ])->withInput();
                }
            }
        }

        $data['user_id'] = auth()->id();
        $data['estado'] = 'Pendiente';

        // ✅ Guardar forzando extensión .pdf (evita que quede .bin)
        if ($request->hasFile('pdf_documento')) {
            $file = $request->file('pdf_documento');
            $name = Str::random(40) . '.pdf';
            $data['pdf_documento'] = $file->storeAs('kits/documento', $name, 'public');
        }

        if ($request->hasFile('pdf_certificado')) {
            $file = $request->file('pdf_certificado');
            $name = Str::random(40) . '.pdf';
            $data['pdf_certificado'] = $file->storeAs('kits/certificado', $name, 'public');
        }

        $registro = KitRegistro::create($data);

        return redirect()
            ->route('kits.registros.show', $registro)
            ->with('status', 'Registro creado correctamente.');
    }

    public function show(KitRegistro $registro)
    {
        abort_unless($registro->user_id === auth()->id(), 403);

        return view('kits.registros.show', compact('registro'));
    }

    public function edit(KitRegistro $registro)
    {
        abort_unless($registro->user_id === auth()->id(), 403);
        abort_if(in_array($registro->estado, ['Aprobado', 'Rechazado', 'Entregado']), 403);

        return view('kits.registros.edit', compact('registro'));
    }

    public function update(Request $request, KitRegistro $registro)
{
    $data = $request->validate([
        'colaborador_nombre' => ['required', 'string', 'max:255'],
        'colaborador_documento' => ['required', 'string', 'max:255'],
        'linea_negocio' => ['required', 'string', 'max:255'],
        'area' => ['required', 'string', 'max:255'],

        'nino_nombre' => ['required', 'string', 'max:255'],
        'nino_documento' => ['required', 'string', 'max:255'],
        'edad' => ['required', 'integer', 'min:1'],
        'grado' => ['required', 'string', 'max:255'],
        'institucion' => ['required', 'string', 'max:255'],
    ]);

    $registro->update($data);

    return redirect()
        ->route('kits.registros.show', $registro)
        ->with('status', 'Registro actualizado correctamente.');
}

}
