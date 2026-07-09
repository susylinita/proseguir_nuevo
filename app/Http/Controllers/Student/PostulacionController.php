<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Support\BankOptions;
use Illuminate\Validation\Rule;

class PostulacionController extends Controller
{
   public function create()
    {
        $user = auth()->user();

        if ($user?->becas_bloqueado) {
            return redirect()
                ->route('student.postulaciones.index')
                ->withErrors([
                    'general' => 'Tu usuario se encuentra bloqueado y no puede solicitar becas. ' . ($user->becas_bloqueado_motivo ?? 'No especificado'),
                ]);
        }

        return view('student.postulaciones.create');
    }

    public function store(Request $request)
{
    $user = auth()->user();
    $data['titular_cuenta'] = auth()->user()->name;

if ($user->becas_bloqueado) {
    return back()->withErrors([
        'general' => 'Tu usuario está bloqueado para solicitar becas. Motivo: ' . ($user->becas_bloqueado_motivo ?? 'No especificado'),
    ]);
}

    
    $baseRules = [
        'tipo_postulacion' => ['required', 'in:primer_semestre,otro_semestre,renovacion'],

        'fecha_nacimiento' => ['nullable', 'date'],
        'tipo_documento' => ['required', 'string', 'max:20'],
        'documento_identidad' => ['required', 'string', 'max:50'],
        'telefono_fijo' => ['nullable', 'string', 'max:30'],
        'telefono_celular' => ['required', 'string', 'max:30'],
        'direccion' => ['nullable', 'string', 'max:120'],
        'barrio' => ['nullable', 'string', 'max:80'],
        'genero' => ['nullable', 'in:F,M,Otro,Prefiero no decir'],

        'nombre_acudiente' => ['required', 'string', 'max:120'],
        'telefono_acudiente' => ['required', 'string', 'max:30'],

        'como_encontro' => ['nullable', 'string', 'max:2000'],

        // Bancarios (se vuelven obligatorios o no, según el tipo)
        'banco' => ['required', Rule::in(array_keys(BankOptions::options()))],
        'titular_cuenta' => ['nullable', 'string', 'max:120'],
        'tipo_cuenta' => ['nullable', 'in:Ahorros,Corriente,Nequi,Daviplata'],
        'numero_cuenta' => ['nullable', 'string', 'max:50'],
        'cuenta_actualizada' => ['nullable'],

        // anexos generales (pdf/jpg/png)
        'anexo_doc_identidad' => ['nullable', 'file', 'max:5120', 'mimetypes:application/pdf,application/x-pdf,application/octet-stream,image/jpeg,image/png'],
        'anexo_foto_documento' => ['nullable', 'file', 'max:5120', 'mimetypes:image/jpeg,image/png'],
        'anexo_certificado_bancario' => ['nullable', 'file', 'max:5120', 'mimetypes:application/pdf,application/x-pdf,application/octet-stream,image/jpeg,image/png'],
        
        'promedio_carrera' => ['nullable', 'numeric', 'min:0', 'max:5'],

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
            'banco' => ['required', Rule::in(array_keys(BankOptions::options()))],
            'titular_cuenta' => ['required', 'string', 'max:120'],
            'tipo_cuenta' => ['required', 'in:Ahorros,Corriente,Nequi,Daviplata'],
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
            'banco' => ['required', Rule::in(array_keys(BankOptions::options()))],
            'titular_cuenta' => ['required', 'string', 'max:120'],
            'tipo_cuenta' => ['required', 'in:Ahorros,Corriente,Nequi,Daviplata'],
            'numero_cuenta' => ['required', 'string', 'max:50'],
        ];
    } else { // renovacion
    $extraRules = [
        'anexo_certificado_notas' => [
            'required',
            'file',
            'max:5120',
            'mimes:pdf,jpg,jpeg,png',
        ],

        'anexo_recibo_matricula' => [
            'required',
            'file',
            'max:5120',
            'mimes:pdf,jpg,jpeg,png',
        ],

        'anexo_certificado_bancario' => [
            $request->boolean('cuenta_actualizada') ? 'required' : 'nullable',
            'file',
            'max:5120',
            'mimes:pdf,jpg,jpeg,png',
        ],

        'banco' => [$request->boolean('cuenta_actualizada') ? 'required' : 'nullable', 'string', 'max:80'],
        'titular_cuenta' => [$request->boolean('cuenta_actualizada') ? 'required' : 'nullable', 'string', 'max:120'],
        'tipo_cuenta' => [$request->boolean('cuenta_actualizada') ? 'required' : 'nullable', 'in:Ahorros,Corriente,Nequi,Daviplata'],
        'numero_cuenta' => [$request->boolean('cuenta_actualizada') ? 'required' : 'nullable', 'string', 'max:50'],
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
        'anexo_foto_documento' => 'postulaciones/expedientes/'.$user->id.'/foto_documento',
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

    
    // Actualizar users con los datos diligenciados en la postulación
    $user->update([
        'tipo_documento' => $data['tipo_documento'],
        'cedula' => $data['documento_identidad'],
    ]);

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
    $data['titular_cuenta'] = auth()->user()->name;
    

    $tipo = $postulacion->tipo_postulacion; // NO permitimos cambiar tipo desde update

    // Base rules (update)
    $baseRules = [
        // puntajes existentes
        'puntaje_saber' => ['required', 'numeric', 'min:0'],
        'promedio_universitario' => ['required', 'numeric', 'min:0'],

        // datos personales
        'fecha_nacimiento' => ['nullable', 'date'],
        'tipo_documento' => ['required', 'string', 'max:20'],
        'documento_identidad' => ['required', 'string', 'max:50'],
        'telefono_fijo' => ['nullable', 'string', 'max:30'],
        'telefono_celular' => ['required', 'string', 'max:30'],
        'direccion' => ['nullable', 'string', 'max:120'],
        'barrio' => ['required', 'string', 'max:80'], // ya lo querías obligatorio
        'genero' => ['nullable', 'in:F,M,Otro,Prefiero no decir'],

        // acudiente
        'nombre_acudiente' => ['required', 'string', 'max:120'],
        'telefono_acudiente' => ['required', 'string', 'max:30'],

        // pregunta abierta
        'como_encontro' => ['nullable', 'string', 'max:2000'],

        // banco (siempre opcional; en renovación solo se usa si cuenta_actualizada)
        'banco' => ['required', Rule::in(array_keys(BankOptions::options()))],
        'titular_cuenta' => ['nullable', 'string', 'max:120'],
        'tipo_cuenta' => ['nullable', 'in:Ahorros,Corriente,Nequi,Daviplata'],
        'numero_cuenta' => ['nullable', 'string', 'max:50'],
        'cuenta_actualizada' => ['nullable', 'boolean'],

        // compatibilidad PDFs antiguos
        'pdf_notas' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        'pdf_matricula' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],

        // anexos generales (NO obligar en update si ya existen)
        'anexo_doc_identidad' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        'anexo_foto_documento' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
        'anexo_certificado_bancario' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

        'promedio_carrera' => ['nullable', 'numeric', 'min:0', 'max:5'],
    ];

    // Reglas por tipo
    if ($tipo === 'primer_semestre') {
        $extraRules = [
            'universidad_aplica' => ['required', 'string', 'max:160'],
            'carrera_aplica' => ['required', 'string', 'max:160'],
        ];
    } elseif ($tipo === 'otro_semestre') {
        $extraRules = [
            'universidad_actual' => ['nullable', 'string', 'max:160'],
            'carrera_actual' => ['required', 'string', 'max:160'],
            'semestre_en_curso' => ['required', 'integer', 'min:1', 'max:12'],
        ];
    } else { // renovacion
    $extraRules = [
        'anexo_certificado_notas' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        'anexo_recibo_matricula' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

        'anexo_certificado_bancario' => [
            $request->boolean('cuenta_actualizada') ? 'required' : 'nullable',
            'file',
            'max:5120',
            'mimes:pdf,jpg,jpeg,png',
        ],
    ];
}

    $data = $request->validate($baseRules + ($extraRules ?? []));

    // Reglas de negocio (tuyas)
    if (($data['puntaje_saber'] ?? 0) < 300) {
        return back()->withErrors(['puntaje_saber' => 'El puntaje Saber debe ser mínimo 300.'])->withInput();
    }
    if (($data['promedio_universitario'] ?? 0) < 3.8) {
        return back()->withErrors(['promedio_universitario' => 'El promedio universitario debe ser mínimo 3.8.'])->withInput();
    }

    $user = auth()->user();

    // Forzar identidad siempre
    $data['estudiante_nombre'] = $user->name;
    $data['estudiante_email']  = $user->email;

    // --- Reglas "obligatorio solo si no existe aún" (para update) ---
    // (evita obligar a re-subir y evita que falle si ya está guardado)

    if ($tipo !== 'renovacion') {
        if (empty($postulacion->anexo_doc_identidad) && ! $request->hasFile('anexo_doc_identidad')) {
            return back()->withErrors(['anexo_doc_identidad' => 'Debes adjuntar el documento de identidad.'])->withInput();
        }
        if (empty($postulacion->anexo_foto_documento) && ! $request->hasFile('anexo_foto_documento')) {
            return back()->withErrors(['anexo_foto_documento' => 'Debes adjuntar la foto tipo documento.'])->withInput();
        }
        if (empty($postulacion->anexo_certificado_bancario) && ! $request->hasFile('anexo_certificado_bancario')) {
            return back()->withErrors(['anexo_certificado_bancario' => 'Debes adjuntar el certificado bancario.'])->withInput();
        }
    } else {
        if (empty($postulacion->anexo_certificado_notas) && ! $request->hasFile('anexo_certificado_notas')) {
            return back()->withErrors(['anexo_certificado_notas' => 'Debes adjuntar el certificado de notas.'])->withInput();
        }
        if (empty($postulacion->anexo_recibo_matricula) && ! $request->hasFile('anexo_recibo_matricula')) {
            return back()->withErrors(['anexo_recibo_matricula' => 'Debes adjuntar el recibo de matrícula.'])->withInput();
        }
    }

    // Guardado de archivos (si no sube, NO se toca lo existente)
    $fileMap = [
        'anexo_doc_identidad' => 'postulaciones/anexos',
        'anexo_foto_documento' => 'postulaciones/expedientes/'.$user->id.'/foto', // como “expediente”
        'anexo_certificado_bancario' => 'postulaciones/anexos',
        'anexo_certificado_notas' => 'postulaciones/renovacion',
        'anexo_recibo_matricula' => 'postulaciones/renovacion',
    ];

    foreach ($fileMap as $field => $dir) {
        if ($request->hasFile($field)) {
            $data[$field] = $request->file($field)->store($dir, 'public');
        } else {
            unset($data[$field]); // importantísimo: no sobrescribir con null
        }
    }

    // PDFs antiguos
    if ($request->hasFile('pdf_notas')) {
        $data['pdf_notas'] = $request->file('pdf_notas')->store('postulaciones/notas', 'public');
    } else {
        unset($data['pdf_notas']);
    }

    if ($request->hasFile('pdf_matricula')) {
        $data['pdf_matricula'] = $request->file('pdf_matricula')->store('postulaciones/matricula', 'public');
    } else {
        unset($data['pdf_matricula']);
    }

    // Blindaje extra: el estudiante no toca esto
    unset($data['estado'], $data['perfil_descriptivo'], $data['tipo_postulacion'], $data['user_id']);

    // Si es renovación y NO marcó cuenta_actualizada, no actualices campos bancarios
    if ($tipo === 'renovacion' && ! $request->boolean('cuenta_actualizada')) {
    unset(
        $data['banco'],
        $data['titular_cuenta'],
        $data['tipo_cuenta'],
        $data['numero_cuenta'],
        $data['anexo_certificado_bancario']
    );

    $data['cuenta_actualizada'] = false;
}

    $postulacion->update($data);

    // Actualizar también los datos del usuario relacionado
    $user->update([
        'tipo_documento' => $data['tipo_documento'] ?? $user->tipo_documento,
        'cedula' => $data['documento_identidad'] ?? $user->cedula,
    ]);

    return redirect()
        ->route('student.postulaciones.show', $postulacion)
        ->with('status', 'Postulación actualizada correctamente.');
}


    public function viewFile(Postulacion $postulacion, string $campo)
{
    $this->authorize('view', $postulacion);

    $allowed = [
        'anexo_doc_identidad',
        'anexo_foto_documento',
        'anexo_certificado_bancario',
        'anexo_certificado_notas',
        'anexo_recibo_matricula',
        'pdf_notas',
        'pdf_matricula',
    ];

    abort_unless(in_array($campo, $allowed, true), 404);

    $path = $postulacion->{$campo};
    abort_if(empty($path), 404);

    $disk = Storage::disk('public');
    abort_if(!$disk->exists($path), 404);

    $mime = $disk->mimeType($path) ?? 'application/octet-stream';
    $filename = basename($path);

    // INLINE para que el navegador intente visualizar (PDF/imagen)
    return response($disk->get($path), 200, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.$filename.'"',
    ]);
}

public function file(Postulacion $postulacion, string $field)
{
    $this->authorize('view', $postulacion);

    $allowed = [
        'anexo_doc_identidad',
        'anexo_foto_documento',
        'anexo_certificado_bancario',
        'pdf_notas',
        'pdf_matricula',
        'anexo_certificado_notas',
        'anexo_recibo_matricula',
    ];

    abort_unless(in_array($field, $allowed, true), 404);

    $path = $postulacion->{$field} ?? null;
    abort_unless($path && Storage::disk('public')->exists($path), 404);

    $mime = Storage::disk('public')->mimeType($path) ?? 'application/octet-stream';
    $filename = basename($path);

    return response()->stream(function () use ($path) {
        echo Storage::disk('public')->get($path);
    }, 200, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.$filename.'"',
        'X-Content-Type-Options' => 'nosniff',
    ]);
}
}
