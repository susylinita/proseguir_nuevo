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
            'nino_nombre' => ['required', 'string', 'max:255'],
            'nino_documento' => ['nullable', 'string', 'max:80'],
            'nino_fecha_nacimiento' => ['nullable', 'date'],
            'institucion' => ['nullable', 'string', 'max:255'],
            'grado' => ['nullable', 'string', 'max:50'],
            'pdf_documento' => $pdfRules,
            'pdf_certificado' => $pdfRules,
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
        abort_unless($registro->user_id === auth()->id(), 403);
        abort_if(in_array($registro->estado, ['Aprobado', 'Rechazado', 'Entregado']), 403);

        $pdfRules = ['nullable', 'file', 'max:5120'];

        $data = $request->validate([
            'nino_nombre' => ['required', 'string', 'max:255'],
            'nino_documento' => ['nullable', 'string', 'max:80'],
            'nino_fecha_nacimiento' => ['nullable', 'date'],
            'institucion' => ['nullable', 'string', 'max:255'],
            'grado' => ['nullable', 'string', 'max:50'],
            'pdf_documento' => $pdfRules,
            'pdf_certificado' => $pdfRules,
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

        // ✅ Reemplazar archivos, borrando el anterior y forzando .pdf
        if ($request->hasFile('pdf_documento')) {
            if ($registro->pdf_documento) {
                Storage::disk('public')->delete($registro->pdf_documento);
            }

            $file = $request->file('pdf_documento');
            $name = Str::random(40) . '.pdf';
            $data['pdf_documento'] = $file->storeAs('kits/documento', $name, 'public');
        }

        if ($request->hasFile('pdf_certificado')) {
            if ($registro->pdf_certificado) {
                Storage::disk('public')->delete($registro->pdf_certificado);
            }

            $file = $request->file('pdf_certificado');
            $name = Str::random(40) . '.pdf';
            $data['pdf_certificado'] = $file->storeAs('kits/certificado', $name, 'public');
        }

        $registro->update($data);

        return redirect()
            ->route('kits.registros.show', $registro)
            ->with('status', 'Registro actualizado correctamente.');
    }
}
