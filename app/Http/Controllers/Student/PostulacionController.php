<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    public function create()
    {
        // Ya no enviamos prefill porque en la vista se muestra auth()->user() como texto
        return view('student.postulaciones.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'puntaje_saber' => ['required', 'numeric', 'min:0'],
            'promedio_universitario' => ['required', 'numeric', 'min:0'],
            'pdf_notas' => ['nullable', 'file', 'max:5120'],
            'pdf_matricula' => ['nullable', 'file', 'max:5120'],
        ]);
        foreach (['pdf_notas', 'pdf_matricula'] as $field) {
            if ($request->hasFile($field)) {
                $ext = strtolower($request->file($field)->getClientOriginalExtension());
                if ($ext !== 'pdf') {
                    return back()->withErrors([
                        $field => 'El archivo debe ser un PDF (.pdf).'
                    ])->withInput();
                }
            }
        }

        // Reglas de negocio
        if ($data['puntaje_saber'] < 300) {
            return back()->withErrors(['puntaje_saber' => 'El puntaje Saber debe ser mínimo 300.'])->withInput();
        }

        if ($data['promedio_universitario'] < 3.8) {
            return back()->withErrors(['promedio_universitario' => 'El promedio universitario debe ser mínimo 3.8.'])->withInput();
        }

        $user = auth()->user();

        // 🔒 FORZAR identidad (no viene del form)
        $data['estudiante_nombre'] = $user->name;
        $data['estudiante_email']  = $user->email;

        // Dueño de la postulación
        $data['user_id'] = $user->id;

        // Estado inicial
        $data['estado'] = 'Pendiente';

        // El estudiante no llena esto
        $data['perfil_descriptivo'] = null;

        // Archivos
        if ($request->hasFile('pdf_notas')) {
            $data['pdf_notas'] = $request->file('pdf_notas')->store('postulaciones/notas', 'public');
        }

        if ($request->hasFile('pdf_matricula')) {
            $data['pdf_matricula'] = $request->file('pdf_matricula')->store('postulaciones/matricula', 'public');
        }

        $postulacion = Postulacion::create($data);

        return redirect()
            ->route('student.postulaciones.show', $postulacion)
            ->with('status', 'Postulación creada correctamente.');
    }

    public function index()
    {
        $postulaciones = Postulacion::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('student.postulaciones.index', compact('postulaciones'));
    }

    public function show(Postulacion $postulacion)
    {
        $this->authorize('view', $postulacion);

        $postulacion->load(['historicoEstados' => fn ($q) => $q->orderBy('cambiado_en')]);

        return view('student.postulaciones.show', compact('postulacion'));
    }

    public function edit(Postulacion $postulacion)
    {
        $this->authorize('update', $postulacion);

        return view('student.postulaciones.edit', compact('postulacion'));
    }

    public function update(Request $request, Postulacion $postulacion)
    {
        $this->authorize('update', $postulacion);

        $data = $request->validate([
            'puntaje_saber' => ['required', 'numeric', 'min:0'],
            'promedio_universitario' => ['required', 'numeric', 'min:0'],
            'pdf_notas' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'pdf_matricula' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        // Reglas de negocio
        if ($data['puntaje_saber'] < 300) {
            return back()->withErrors(['puntaje_saber' => 'El puntaje Saber debe ser mínimo 300.'])->withInput();
        }

        if ($data['promedio_universitario'] < 3.8) {
            return back()->withErrors(['promedio_universitario' => 'El promedio universitario debe ser mínimo 3.8.'])->withInput();
        }

        $user = auth()->user();

        // 🔒 FORZAR identidad SIEMPRE
        $data['estudiante_nombre'] = $user->name;
        $data['estudiante_email']  = $user->email;

        // Archivos (si no sube, no se toca)
        if ($request->hasFile('pdf_notas')) {
            $data['pdf_notas'] = $request->file('pdf_notas')->store('postulaciones/notas', 'public');
        }

        if ($request->hasFile('pdf_matricula')) {
            $data['pdf_matricula'] = $request->file('pdf_matricula')->store('postulaciones/matricula', 'public');
        }

        // Blindaje extra (opcional)
        unset($data['estado'], $data['perfil_descriptivo']);

        $postulacion->update($data);

        return redirect()
            ->route('student.postulaciones.show', $postulacion)
            ->with('status', 'Postulación actualizada correctamente.');
    }
}
