<x-app-layout>
    <style>
    .student-postulation-page {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        color: #0f172a;
    }

    .student-postulation-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .student-postulation-inner {
        padding: 2rem;
    }

    .student-section {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        padding: 1.5rem;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
    }

    .student-section-title {
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #1e3a8a;
        margin-bottom: 1rem;
        padding-bottom: .85rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .student-postulation-page label {
        display: block;
        margin-bottom: .45rem;
        font-size: 1rem;
        font-weight: 700;
        color: #334155;
    }

    .student-postulation-page input[type="text"],
    .student-postulation-page input[type="email"],
    .student-postulation-page input[type="number"],
    .student-postulation-page input[type="date"],
    .student-postulation-page select,
    .student-postulation-page textarea {
        width: 100%;
        border-radius: 14px !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        padding: .85rem 1rem !important;
        font-size: 1rem !important;
        line-height: 1.5rem !important;
        color: #0f172a !important;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05) !important;
        outline: none !important;
    }

    .student-postulation-page input:focus,
    .student-postulation-page select:focus,
    .student-postulation-page textarea:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.13) !important;
    }

    .student-postulation-page input[type="file"] {
        width: 100%;
        border-radius: 14px;
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        padding: .9rem;
        font-size: .95rem;
        color: #334155;
    }

    .student-readonly-box {
        background: linear-gradient(135deg, #eff6ff, #f8fafc);
        border: 1px solid #dbeafe;
        border-radius: 22px;
        padding: 1.5rem;
    }

    .student-current-file {
        margin-top: .5rem;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: .75rem;
        font-size: .9rem;
        color: #64748b;
    }

    .student-actions-bar {
        position: sticky;
        bottom: 0;
        z-index: 20;
        margin-top: 2rem;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        background: rgba(255, 255, 255, .94);
        backdrop-filter: blur(10px);
        padding: 1rem;
        box-shadow: 0 -10px 30px rgba(15, 23, 42, 0.08);
    }

    .student-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #1d4ed8;
        padding: .85rem 1.4rem;
        font-size: 1rem;
        font-weight: 800;
        color: #ffffff;
    }

    .student-btn-primary:hover {
        background: #1e40af;
    }

    .student-btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        padding: .85rem 1.4rem;
        font-size: 1rem;
        font-weight: 800;
        color: #334155;
    }

    .student-btn-secondary:hover {
        background: #f8fafc;
    }
</style>
    <x-slot name="header">
    <style>
        .student-top-hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .student-top-hero-content {
            position: relative;
            padding: 2rem;
        }

        .student-top-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .85);
            padding: .45rem .85rem;
            font-size: .9rem;
            font-weight: 800;
            color: #334155;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
        }

        .student-top-title {
            margin-top: 1rem;
            font-size: 2rem;
            line-height: 2.4rem;
            font-weight: 900;
            letter-spacing: -0.035em;
        }

        .student-top-description {
            margin-top: .75rem;
            max-width: 46rem;
            font-size: 1.05rem;
            line-height: 1.75rem;
            color: #64748b;
        }

        .student-top-note {
            margin-top: .75rem;
            font-size: .95rem;
            font-weight: 600;
            color: #64748b;
        }

        .student-top-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: .85rem 1.25rem;
            font-size: 1rem;
            font-weight: 800;
            color: #334155;
            transition: all .15s ease;
            text-decoration: none;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.05);
        }

        .student-top-btn-secondary:hover {
            background: #f8fafc;
        }
    </style>

    <div class="student-top-hero">
        <div class="absolute inset-0">
            <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
            <div class="absolute -top-20 -right-16 h-64 w-64 rounded-full bg-emerald-200/35 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-16 h-64 w-64 rounded-full bg-blue-200/35 blur-3xl"></div>
            <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-900 to-emerald-500"></div>
        </div>

        <div class="student-top-hero-content">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="student-top-badge">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Editando solicitud
                    </div>

                    <h1 class="student-top-title">
                        <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                            Editar postulación #{{ $postulacion->id }}
                        </span>
                    </h1>

                    <p class="student-top-description">
                        Puedes modificar tu información mientras la postulación esté disponible para edición.
                    </p>

                    <p class="student-top-note">
                        Verifica cuidadosamente antes de guardar los cambios.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                       class="student-top-btn-secondary">
                        ← Volver al detalle
                    </a>

                    <a href="{{ route('student.postulaciones.index') }}"
                       class="student-top-btn-secondary">
                        Mis postulaciones
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-slot>

<div class="student-postulation-page max-w-6xl mx-auto py-10 px-6">
    

    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
            <div class="text-sm font-semibold text-red-800">Revisa los campos:</div>
            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="student-postulation-card">
    <div class="student-postulation-inner">

    @php
        $tipo = old('tipo_postulacion', $postulacion->tipo_postulacion ?? 'primer_semestre');
        $cuentaActualizadaOld = old('cuenta_actualizada', $postulacion->cuenta_actualizada ? 1 : 0);
        $cuentaActualizadaChecked = (bool) $cuentaActualizadaOld;

        $fileUrl = fn(string $field) => route('student.postulaciones.file', [$postulacion, $field]);

        $badgeTipo = match ($tipo) {
            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
            'otro_semestre'   => 'Ingreso a otro semestre (primera vez)',
            'renovacion'      => 'Renovación (ya becado)',
            default           => 'N/D',
        };
    @endphp

    

            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="text-sm font-semibold text-red-800">Revisa los campos:</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"
                     x-data="{
                        tipo: '{{ $tipo }}',
                        cuentaActualizada: {{ $cuentaActualizadaChecked ? 'true' : 'false' }}
                     }">

                    <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 p-5 text-base leading-7 text-slate-700">
                        Puedes actualizar tu información y adjuntar documentos mientras tu postulación esté en
                        <strong>Pendiente</strong>.
                    </div>

                    {{-- Datos del postulante (solo lectura) --}}
                    <div class="mb-6 student-readonly-box">
                        <div class="student-section-title">
                            Datos del postulante
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-gray-500">Nombre</div>
                                <div class="font-medium text-gray-900">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Correo electrónico</div>
                                <div class="font-medium text-gray-900">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 text-xs text-gray-500">
                            Estos datos se toman automáticamente de tu cuenta y no se pueden modificar desde la postulación.
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('student.postulaciones.update', $postulacion) }}"
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Tipo (solo lectura en edición) --}}
                        <div class="student-section">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-2">Tipo de postulación</div>
                            <div class="text-sm font-medium text-gray-900">{{ $badgeTipo }}</div>
                            {{-- enviamos el tipo para que update pueda validar reglas por tipo --}}
                            <input type="hidden" name="tipo_postulacion" :value="tipo">
                        </div>

                        {{-- Datos personales --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Datos personales
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                                    <input name="fecha_nacimiento" type="date"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('fecha_nacimiento', optional($postulacion->fecha_nacimiento)->format('Y-m-d')) }}">
                                </div>

                                <div>
                                    <label for="tipo_documento" class="block text-sm font-medium text-gray-700">
                                        Tipo de documento
                                    </label>

                                    <select
                                        id="tipo_documento"
                                        name="tipo_documento"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    >
                                        <option value="">Seleccione una opción</option>

                                        <option value="CC" @selected(old('tipo_documento', $postulacion->tipo_documento) === 'CC')>
                                            Cédula de ciudadanía
                                        </option>

                                        <option value="TI" @selected(old('tipo_documento', $postulacion->tipo_documento) === 'TI')>
                                            Tarjeta de identidad
                                        </option>

                                        <option value="CE" @selected(old('tipo_documento', $postulacion->tipo_documento) === 'CE')>
                                            Cédula de extranjería
                                        </option>

                                        <option value="PAS" @selected(old('tipo_documento', $postulacion->tipo_documento) === 'PAS')>
                                            Pasaporte
                                        </option>

                                        <option value="PEP" @selected(old('tipo_documento', $postulacion->tipo_documento) === 'PEP')>
                                            Permiso especial de permanencia
                                        </option>

                                        <option value="RC" @selected(old('tipo_documento', $postulacion->tipo_documento) === 'RC')>
                                            Registro civil
                                        </option>
                                    </select>

                                    @error('tipo_documento')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="documento_identidad" class="block text-sm font-medium text-gray-700">
                                        Número de documento
                                    </label>

                                    <input
                                        id="documento_identidad"
                                        name="documento_identidad"
                                        type="text"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        value="{{ old('documento_identidad', $postulacion->documento_identidad) }}"
                                    >

                                    @error('documento_identidad')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono celular</label>
                                    <input name="telefono_celular" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_celular', $postulacion->telefono_celular) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono fijo (opcional)</label>
                                    <input name="telefono_fijo" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_fijo', $postulacion->telefono_fijo) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dirección (opcional)</label>
                                    <input name="direccion" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('direccion', $postulacion->direccion) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Barrio</label>
                                    <input name="barrio" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('barrio', $postulacion->barrio) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Género</label>
                                    <select name="genero"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="F" @selected(old('genero', $postulacion->genero)==='F')>F</option>
                                        <option value="M" @selected(old('genero', $postulacion->genero)==='M')>M</option>
                                        <option value="Otro" @selected(old('genero', $postulacion->genero)==='Otro')>Otro</option>
                                        <option value="Prefiero no decir" @selected(old('genero', $postulacion->genero)==='Prefiero no decir')>Prefiero no decir</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Acudiente --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Datos del acudiente
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nombre acudiente</label>
                                    <input name="nombre_acudiente" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('nombre_acudiente', $postulacion->nombre_acudiente) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono acudiente</label>
                                    <input name="telefono_acudiente" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_acudiente', $postulacion->telefono_acudiente) }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Estudios --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Estudios
                            </div>

                            {{-- Primer semestre --}}
                            <div x-show="tipo === 'primer_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad a la que quiere aplicar</label>
                                        <input name="universidad_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_aplica', $postulacion->universidad_aplica) }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_aplica', $postulacion->carrera_aplica) }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Otro semestre --}}
                            <div x-show="tipo === 'otro_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad (opcional)</label>
                                        <input name="universidad_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_actual', $postulacion->universidad_actual) }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_actual', $postulacion->carrera_actual) }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Semestre en curso</label>
                                        <input name="semestre_en_curso" type="number" min="1" max="12"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('semestre_en_curso', $postulacion->semestre_en_curso) }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Renovación --}}
                            <div x-show="tipo === 'renovacion'" x-cloak class="space-y-4">
                                <p class="text-sm text-gray-700">
                                    Para renovación, sube únicamente: <strong>certificado de notas</strong> y <strong>recibo de matrícula</strong>.
                                    Si cambiaste la cuenta bancaria, actívalo y actualiza los datos.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Certificado de notas (PDF/JPG)</label>
                                        <input name="anexo_certificado_notas" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                               class="mt-1 block w-full text-sm text-gray-700">
                                        @if ($postulacion->anexo_certificado_notas)
                                            <p class="student-current-file">
                                                Actual: <span class="font-medium">{{ basename($postulacion->anexo_certificado_notas) }}</span>
                                                · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_certificado_notas') }}" target="_blank" rel="noopener">Ver</a>
                                            </p>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Recibo matrícula (PDF/JPG)</label>
                                        <input name="anexo_recibo_matricula" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                               class="mt-1 block w-full text-sm text-gray-700">
                                        @if ($postulacion->anexo_recibo_matricula)
                                            <p class="student-current-file">
                                                Actual: <span class="font-medium">{{ basename($postulacion->anexo_recibo_matricula) }}</span>
                                                · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_recibo_matricula') }}" target="_blank" rel="noopener">Ver</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <label class="inline-flex items-center text-sm text-gray-700">
                                    <input type="checkbox" name="cuenta_actualizada" value="1"
                                           x-model="cuentaActualizada"
                                           class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                    <span class="ms-2">Actualicé mis datos bancarios</span>
                                </label>
                            </div>
                        </div>

                        {{-- Datos bancarios --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Datos bancarios
                            </div>

                            <p class="text-xs text-gray-500 mb-4">
                                Si es tu primera beca, diligencia estos datos. Si es renovación, solo actualiza si cambiaste de cuenta.
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                 :class="(tipo === 'renovacion' && !cuentaActualizada) ? 'opacity-50 pointer-events-none' : ''">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Banco</label>
                                    <input name="banco" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('banco', $postulacion->banco) }}">
                                </div>

                                <div>
                                    <input
                                        name="titular_cuenta"
                                        type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 bg-slate-100 text-slate-700 shadow-sm cursor-not-allowed"
                                        value="{{ auth()->user()->name }}"
                                        readonly
                                    >

                                    <p class="mt-1 text-xs text-slate-500">
                                        El titular de la cuenta se toma automáticamente del nombre del postulante y no puede modificarse.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipo de cuenta</label>
                                    <select name="tipo_cuenta" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="Ahorros" @selected(old('tipo_cuenta', $postulacion->tipo_cuenta)==='Ahorros')>Ahorros</option>
                                        <option value="Corriente" @selected(old('tipo_cuenta', $postulacion->tipo_cuenta)==='Corriente')>Corriente</option>
                                        <option value="Nequi" @selected(old('tipo_cuenta', $postulacion->tipo_cuenta)==='Nequi')>Nequi</option>
                                        <option value="Daviplata" @selected(old('tipo_cuenta', $postulacion->tipo_cuenta)==='Daviplata')>Daviplata</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de cuenta</label>
                                    <input name="numero_cuenta" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('numero_cuenta', $postulacion->numero_cuenta) }}">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Certificado cuenta (PDF/JPG)</label>
                                <input name="anexo_certificado_bancario" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                       class="mt-1 block w-full text-sm text-gray-700"
                                       :disabled="(tipo === 'renovacion' && !cuentaActualizada)">
                                @if ($postulacion->anexo_certificado_bancario)
                                    <p class="student-current-file">
                                        Actual: <span class="font-medium">{{ basename($postulacion->anexo_certificado_bancario) }}</span>
                                        · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_certificado_bancario') }}" target="_blank" rel="noopener">Ver</a>
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Anexos (primera vez) --}}
                        <div class="rounded-md border border-gray-200 p-4"
                             x-show="tipo !== 'renovacion'" x-cloak>
                            <div class="student-section-title">
                                Anexos (primera vez)
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Documento de identidad (PDF/JPG)</label>
                                    <input name="anexo_doc_identidad" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    @if ($postulacion->anexo_doc_identidad)
                                        <p class="student-current-file">
                                            Actual: <span class="font-medium">{{ basename($postulacion->anexo_doc_identidad) }}</span>
                                            · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_doc_identidad') }}" target="_blank" rel="noopener">Ver</a>
                                        </p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Foto tipo documento (fondo blanco)</label>
                                    <input name="anexo_foto_documento" type="file" accept=".jpg,.jpeg,.png,image/*"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    <p class="student-current-file">Esta foto la ve gerencia.</p>

                                    @if ($postulacion->anexo_foto_documento)
                                        <div class="mt-2 flex items-start gap-3">
                                            <img
                                                src="{{ $fileUrl('anexo_foto_documento') }}"
                                                alt="Foto actual"
                                                class="w-20 h-auto rounded-md border border-gray-300"
                                            >
                                            <div class="text-xs text-gray-500">
                                                Actual: <span class="font-medium">{{ basename($postulacion->anexo_foto_documento) }}</span>
                                                <div>
                                                    <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_foto_documento') }}" target="_blank" rel="noopener">Ver</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Promedio de carrera (0–5)
                                    </label>
                                    <input name="promedio_carrera" type="number" step="0.01" min="0" max="5"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('promedio_carrera', $postulacion->promedio_carrera) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Puntajes (existentes) --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Puntajes
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="puntaje_saber">
                                        Puntaje Saber (mín. 300)
                                    </label>
                                    <input id="puntaje_saber" name="puntaje_saber" type="number" step="0.01" min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('puntaje_saber', $postulacion->puntaje_saber) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="promedio_universitario">
                                        Promedio universitario (mín. 3.8)
                                    </label>
                                    <input id="promedio_universitario" name="promedio_universitario" type="number" step="0.01" min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('promedio_universitario', $postulacion->promedio_universitario) }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Información adicional (de último) --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Información adicional
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    ¿Cómo encontraron la Fundación Proseguir?
                                </label>
                                <textarea name="como_encontro" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                          placeholder="Cuéntanos brevemente...">{{ old('como_encontro', $postulacion->como_encontro) }}</textarea>
                            </div>
                        </div>

                        {{-- PDFs antiguos (si los sigues usando) --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Documentos académicos
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="pdf_notas">
                                        PDF Notas
                                    </label>
                                    <input id="pdf_notas" name="pdf_notas" type="file" accept=".pdf,application/pdf"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    @if ($postulacion->pdf_notas)
                                        <p class="student-current-file">
                                            Actual: <span class="font-medium">{{ basename($postulacion->pdf_notas) }}</span>
                                            · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('pdf_notas') }}" target="_blank" rel="noopener">Ver</a>
                                        </p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="pdf_matricula">
                                        PDF Matrícula
                                    </label>
                                    <input id="pdf_matricula" name="pdf_matricula" type="file" accept=".pdf,application/pdf"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    @if ($postulacion->pdf_matricula)
                                        <p class="student-current-file">
                                            Actual: <span class="font-medium">{{ basename($postulacion->pdf_matricula) }}</span>
                                            · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('pdf_matricula') }}" target="_blank" rel="noopener">Ver</a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="student-actions-bar">
                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                            class="student-btn-secondary">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="student-btn-primary">
                                Guardar cambios
                            </button>
                        </div>
                    </div>

                    </form>

                </div>
            </div>


</x-app-layout>
