<x-app-layout>
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
                            Nueva solicitud
                        </div>

                        <h1 class="student-top-title">
                            <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                                Crear postulación
                            </span>
                        </h1>

                        <p class="student-top-description">
                            Completa cuidadosamente la información requerida para enviar tu solicitud a revisión de coordinación y gerencia.
                        </p>

                        <p class="student-top-note">
                            Asegúrate de adjuntar todos los documentos obligatorios.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('student.postulaciones.index') }}"
                           class="student-top-btn-secondary">
                            ← Volver a mis postulaciones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
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

        .student-postulation-page p,
        .student-postulation-page .help-text {
            font-size: .95rem;
            line-height: 1.55rem;
            color: #64748b;
        }

        .student-readonly-box {
            background: linear-gradient(135deg, #eff6ff, #f8fafc);
            border: 1px solid #dbeafe;
            border-radius: 22px;
            padding: 1.5rem;
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
            transition: all .15s ease;
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
            transition: all .15s ease;
        }

        .student-btn-secondary:hover {
            background: #f8fafc;
        }
    </style>

    <div class="student-postulation-page max-w-6xl mx-auto py-10 px-6">

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

            <div class="student-postulation-card">
            <div class="student-postulation-inner"
                     x-data="{
                        tipo: '{{ old('tipo_postulacion', 'primer_semestre') }}',
                        cuentaActualizada: {{ old('cuenta_actualizada', 0) ? 'true' : 'false' }}
                     }">

                    {{-- Bloque informativo (solo lectura) --}}
                    <div class="student-readonly-box">
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
                          action="{{ route('student.postulaciones.store') }}"
                          enctype="multipart/form-data"
                          class="mt-6 space-y-6">
                        @csrf

                        {{-- Tipo de postulación --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tipo de postulación
                            </label>
                            <select name="tipo_postulacion"
                                    x-model="tipo"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="primer_semestre">Ingreso a primer semestre (primera vez)</option>
                                <option value="otro_semestre">Ingreso a otro semestre (primera vez)</option>
                                <option value="renovacion">Renovación (ya becado)</option>
                            </select>

                            <p class="mt-2 text-xs text-gray-500">
                                La renovación se maneja como una nueva postulación.
                            </p>
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
                                           value="{{ old('fecha_nacimiento') }}">
                                </div>

                                <div>
                        <label for="tipo_documento" class="block text-sm font-medium text-gray-700">
                            Tipo de documento
                        </label>

                        <select
                            id="tipo_documento"
                            name="tipo_documento"
                            required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Seleccione una opción</option>
                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de ciudadanía</option>
                            <option value="TI" {{ old('tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de identidad</option>
                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de extranjería</option>
                            <option value="PAS" {{ old('tipo_documento') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="RC" {{ old('tipo_documento') == 'RC' ? 'selected' : '' }}>Registro civil</option>
                        </select>

                        @error('tipo_documento')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de documento</label>
                                    <input name="documento_identidad" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('documento_identidad') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono celular</label>
                                    <input name="telefono_celular" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_celular') }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono fijo (opcional)</label>
                                    <input name="telefono_fijo" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_fijo') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dirección (opcional)</label>
                                    <input name="direccion" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('direccion') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Barrio (opcional)</label>
                                    <input name="barrio" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('barrio') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Género</label>
                                    <select name="genero"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="F" @selected(old('genero')==='F')>F</option>
                                        <option value="M" @selected(old('genero')==='M')>M</option>
                                        <option value="Otro" @selected(old('genero')==='Otro')>Otro</option>
                                        <option value="Prefiero no decir" @selected(old('genero')==='Prefiero no decir')>Prefiero no decir</option>
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
                                           value="{{ old('nombre_acudiente') }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono acudiente</label>
                                    <input name="telefono_acudiente" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_acudiente') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Estudios (según tipo) --}}
                        <div class="student-section">
                            <div class="student-section-title">
                                Estudios
                            </div>

                            {{-- Primer semestre --}}
                            <div x-show="tipo == 'primer_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad a la que quiere aplicar</label>
                                        <input name="universidad_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_aplica') }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_aplica') }}">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500">
                                    Recuerda: la beca aplica únicamente para programas de <strong>pregrado</strong>.
                                </p>
                            </div>

                            {{-- Otro semestre (estudiante activo) --}}
                            <div x-show="tipo == 'otro_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad (opcional)</label>
                                        <input name="universidad_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_actual') }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_actual') }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Semestre en curso</label>
                                        <input name="semestre_en_curso" type="number" min="1" max="12"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('semestre_en_curso') }}">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500">
                                    La beca cubre desde el semestre actual en adelante (no retroactiva).
                                </p>
                            </div>

                            {{-- Renovación --}}
                            <div x-show="tipo == 'renovacion'" x-cloak class="space-y-4">
                                <p class="text-sm text-gray-700">
                                    Para renovación, sube únicamente: <strong>certificado de notas</strong> y <strong>recibo de matrícula</strong>.
                                    Si cambiaste la cuenta bancaria, actívalo y actualiza los datos.
                                </p>

        

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
                                @php
    $bancos = \App\Support\BankOptions::options();
@endphp

<div>
    <label class="block text-sm font-medium text-gray-700">Banco</label>

    <select name="banco"
            id="banco"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        <option value="">Seleccione el banco</option>

        @foreach ($bancos as $value => $label)
            <option value="{{ $value }}" @selected(old('banco', $postulacion->banco ?? '') === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Titular de la cuenta</label>
                                    <input name="titular_cuenta" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('titular_cuenta') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipo de cuenta</label>
                                    <select name="tipo_cuenta" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="Ahorros" @selected(old('tipo_cuenta')==='Ahorros')>Ahorros</option>
                                        <option value="Corriente" @selected(old('tipo_cuenta')==='Corriente')>Corriente</option>
                                        <option value="Nequi" @selected(old('tipo_cuenta')==='Nequi')>Nequi</option>
                                        <option value="Daviplata" @selected(old('tipo_cuenta')==='Daviplata')>Daviplata</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de cuenta</label>
                                    <input name="numero_cuenta" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('numero_cuenta') }}">
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4"
                                 x-show="tipo !== 'renovacion' || cuentaActualizada" x-cloak>
                               
                            </div>
                        </div>

                                        {{-- Pregunta abierta --}}
<div class="student-section">
    <div class="student-section-title">
        <span x-show="tipo == 'renovacion'" x-cloak>
            Recomendación para la fundación o sugerencia
        </span>

        <span x-show="tipo != 'renovacion'" x-cloak>
            Información adicional
        </span>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            <span x-show="tipo == 'renovacion'" x-cloak>
                Recomendación para la fundación o sugerencia
            </span>

            <span x-show="tipo != 'renovacion'" x-cloak>
                ¿Cómo encontró la Fundación Proseguir?
            </span>
        </label>

        <textarea
            name="como_encontro"
            rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            :placeholder="tipo == 'renovacion'
                ? 'Escribe una recomendación o sugerencia para la fundación...'
                : 'Cuéntanos brevemente cómo encontraste la fundación...'"
        >{{ old('como_encontro') }}</textarea>
    </div>
</div>

{{-- Promedio de carrera --}}
<div class="rounded-md border border-gray-200 p-4" x-show="tipo != 'renovacion'" x-cloak>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Promedio de carrera (0–5)
            </label>
            <input
                name="promedio_carrera"
                type="number"
                step="0.01"
                min="0"
                max="5"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                value="{{ old('promedio_carrera') }}"
            >
        </div>
    </div>
</div>
                    
                        {{-- Anexos --}}
<div class="student-section">
    <div class="student-section-title">
        Anexos
    </div>

    {{-- Anexos para primera vez --}}
    <div x-show="tipo != 'renovacion'" x-cloak class="space-y-4">
        <p class="text-sm text-gray-700">
            Adjunta los documentos requeridos para la solicitud de beca por primera vez.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Documento de identidad (PDF/JPG)
                </label>
                <input
                    name="anexo_doc_identidad"
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Foto tipo documento (fondo blanco)
                </label>
                <input
                    name="anexo_foto_documento"
                    type="file"
                    accept=".jpg,.jpeg,.png,image/*"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
                <p class="mt-1 text-xs text-gray-500">
                    Esta foto la ve gerencia.
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Certificado cuenta bancaria (PDF/JPG)
                </label>
                <input
                    name="anexo_certificado_bancario"
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    PDF Notas
                </label>
                <input
                    name="pdf_notas"
                    type="file"
                    accept=".pdf,application/pdf"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    PDF Matrícula
                </label>
                <input
                    name="pdf_matricula"
                    type="file"
                    accept=".pdf,application/pdf"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>
        </div>
    </div>

    {{-- Anexos para renovación --}}
<div x-show="tipo == 'renovacion'" x-cloak class="space-y-4">
    <p class="text-sm text-gray-700">
        Para renovación, adjunta el certificado de notas y el recibo de matrícula.
        Si actualizaste tu cuenta bancaria, marca la opción correspondiente y adjunta el certificado bancario.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Certificado de notas (PDF/JPG)
            </label>
            <input
                name="anexo_certificado_notas"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                class="mt-1 block w-full text-sm text-gray-700"
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Recibo de matrícula (PDF/JPG)
            </label>
            <input
                name="anexo_recibo_matricula"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                class="mt-1 block w-full text-sm text-gray-700"
            >
        </div>
    </div>

    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
        <label class="inline-flex items-center text-sm text-gray-700">
            <input
                type="checkbox"
                name="cuenta_actualizada"
                value="1"
                x-model="cuentaActualizada"
                class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
            >
            <span class="ms-2">Actualicé mis datos bancarios</span>
        </label>

        <div x-show="cuentaActualizada" x-cloak class="mt-4">
            <label class="block text-sm font-medium text-gray-700">
                Certificado cuenta bancaria (PDF/JPG)
            </label>
            <input
                name="anexo_certificado_bancario"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                class="mt-1 block w-full text-sm text-gray-700"
            >
        </div>
    </div>
</div>
    <div class="form-check mt-3">
    <input 
        class="form-check-input" 
        type="checkbox" 
        name="acepta_tratamiento_datos" 
        id="acepta_tratamiento_datos" 
        value="1"
        {{ old('acepta_tratamiento_datos') ? 'checked' : '' }}
        required
    >

    <label class="form-check-label" for="acepta_tratamiento_datos">
        He leído y Acepto la 
        <a href="{{ asset('storage/politica-datos.pdf') }}" 
            target="_blank" 
            style="color: #0d6efd; text-decoration: underline;">
                Política de Tratamiento de Datos Personales
            </a>

    </label>

    @error('acepta_tratamiento_datos')
        <div class="text-danger mt-1">
            {{ $message }}
        </div>
    @enderror
</div>


    </div>

    @error('acepta_tratamiento_datos')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                        {{-- BOTONES --}}
                    <div class="student-actions-bar">
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('student.postulaciones.index') }}"
                        class="student-btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="student-btn-primary">
                            Crear postulación
                        </button>
                    </div>
                </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
