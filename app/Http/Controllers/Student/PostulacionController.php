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
    
    $baseRules = [
        'tipo_postulacion' => ['required', 'in:primer_semestre,otro_semestre,renovacion'],

        'fecha_nacimiento' => ['nullable', 'date'],
        'documento_identidad' => ['nullable', 'string', 'max:50'],
        'telefono_fijo' => ['nullable', 'string', 'max:30'],
        'telefono_celular' => ['required', 'string', 'max:30'],
        'direccion' => ['nullable', 'string', 'max:120'],
        'barrio' => ['nullable', 'string', 'max:80'],
        'genero' => ['nullable', 'in:F,M,Otro,Prefiero no decir'],

        'nombre_acudiente' => ['required', 'string', 'max:120'],
        'telefono_acudiente' => ['required', 'string', 'max:30'],

        'como_encontro' => ['nullable', 'string', 'max:2000'],

        // Bancarios (se vuelven obligatorios o no, según el tipo)
        'banco' => ['nullable', 'string', 'max:80'],
        'titular_cuenta' => ['nullable', 'string', 'max:120'],
        'tipo_cuenta' => ['nullable', 'in:Ahorros,Corriente'],
        'numero_cuenta' => ['nullable', 'string', 'max:50'],
        'cuenta_actualizada' => ['nullable'],

        // anexos generales (pdf/jpg/png)
        'anexo_doc_identidad' => ['required', 'file', 'max:5120', 'mimetypes:application/pdf,application/x-pdf,application/octet-stream,image/jpeg,image/png'],
        'anexo_foto_documento' => ['required', 'file', 'max:5120', 'mimetypes:image/jpeg,image/png'],
        'anexo_certificado_bancario' => ['required', 'file', 'max:5120', 'mimetypes:application/pdf,application/x-pdf,application/octet-stream,image/jpeg,image/png'],

        'promedio_carrera' => ['nullable', 'numeric', 'min:0', 'max:5'],

        // compatibilidad anterior
        'pdf_notas' => ['nullable', 'file', 'max:5120', 'mimetypes:application/pdf,application/x-pdf,application/octet-stream'],
        'pdf_matricula' => ['nullable', 'file', 'max:5120', 'mimetypes:application/pdf,application/x-pdf,application/octet-stream'],
    ];

    $tipo = $request->input('tipo_postulacion');

    // ✅ Reglas por tipo
    if ($tipo === 'primer_semestre') {
        $extraRules = [
            'universidad_aplica' => ['required', 'string', 'max:160'],
            'carrera_aplica' => ['required', 'string', 'max:160'],

            // Primera vez → anexos requeridos (según tu requerimiento)
            'anexo_doc_identidad' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'anexo_foto_documento' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'anexo_certificado_bancario' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

            // Bancarios requeridos en primera vez
            'banco' => ['required', 'string', 'max:80'],
            'titular_cuenta' => ['required', 'string', 'max:120'],
            'tipo_cuenta' => ['required', 'in:Ahorros,Corriente'],
            'numero_cuenta' => ['required', 'string', 'max:50'],
        ];
    } elseif ($tipo === 'otro_semestre') {
        $extraRules = [
            'universidad_actual' => ['nullable', 'string', 'max:160'],
            'carrera_actual' => ['required', 'string', 'max:160'],
            'semestre_en_curso' => ['required', 'integer', 'min:1', 'max:12'],

            // Primera vez → anexos requeridos
            'anexo_doc_identidad' => ['required', 'file', 'max:5120', 'mimetypes:application/pdf,image/jpeg,image/png'],
            'anexo_foto_documento' => ['required', 'file', 'max:5120', 'mimetypes:image/jpeg,image/png'],
            'anexo_certificado_bancario' => ['required', 'file', 'max:5120', 'mimetypes:application/pdf,image/jpeg,image/png'],

            // Bancarios requeridos en primera vez
            'banco' => ['required', 'string', 'max:80'],
            'titular_cuenta' => ['required', 'string', 'max:120'],
            'tipo_cuenta' => ['required', 'in:Ahorros,Corriente'],
            'numero_cuenta' => ['required', 'string', 'max:50'],
        ];
    } else { // renovacion
        $extraRules = [
            'pdf_notas' => ['required', 'file', 'max:5120', 'mimetypes:application/pdf'],
            'pdf_matricula' => ['required', 'file', 'max:5120', 'mimetypes:application/pdf'],

        ];
    }

    $data = $request->validate($baseRules + $extraRules);

    // ✅ Normalizar boolean checkbox
    $data['cuenta_actualizada'] = $request->boolean('cuenta_actualizada');

    $user = auth()->user();

    // 🔒 Forzar identidad
    $data['estudiante_nombre'] = $user->name;
    $data['estudiante_email']  = $user->email;
    $data['user_id'] = $user->id;

    // Estado inicial
    $data['estado'] = 'Pendiente';
    $data['perfil_descriptivo'] = null;

    // ✅ Si es renovación y NO actualizó cuenta: limpiar bancarios + certificado bancario
    if ($tipo === 'renovacion' && ! $data['cuenta_actualizada']) {
        $data['banco'] = null;
        $data['titular_cuenta'] = null;
        $data['tipo_cuenta'] = null;
        $data['numero_cuenta'] = null;
        $data['anexo_certificado_bancario'] = null;
    }

    // ✅ Guardado de archivos
    $fileMap = [
        'anexo_doc_identidad' => 'postulaciones/anexos',
        'anexo_foto_documento' => 'postulaciones/anexos',
        'anexo_certificado_bancario' => 'postulaciones/anexos',
        'anexo_certificado_notas' => 'postulaciones/renovacion',
        'anexo_recibo_matricula' => 'postulaciones/renovacion',
        'pdf_notas' => 'postulaciones/notas',
        'pdf_matricula' => 'postulaciones/matricula',
    ];

    foreach ($fileMap as $field => $dir) {
        if ($request->hasFile($field)) {
            $data[$field] = $request->file($field)->store($dir, 'public');
        }
    }

    // ✅ Si no es "otro_semestre", no guardes semestre_en_curso por error
    if ($tipo !== 'otro_semestre') {
        $data['semestre_en_curso'] = null;
    }

    $postulacion = \App\Models\Postulacion::create($data);

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
