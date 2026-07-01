<x-app-layout>
    <style>
        .student-show-page {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #0f172a;
        }

        .student-show-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
            overflow: hidden;
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
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #1e3a8a;
            margin-bottom: 1rem;
            padding-bottom: .85rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .student-label {
            font-size: .95rem;
            font-weight: 700;
            color: #64748b;
        }

        .student-value {
            margin-top: .25rem;
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            word-break: break-word;
        }

        .student-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: #1d4ed8;
            padding: .85rem 1.25rem;
            font-size: 1rem;
            font-weight: 800;
            color: #ffffff;
            transition: all .15s ease;
            text-decoration: none;
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
            padding: .85rem 1.25rem;
            font-size: 1rem;
            font-weight: 800;
            color: #334155;
            transition: all .15s ease;
            text-decoration: none;
        }

        .student-btn-secondary:hover {
            background: #f8fafc;
        }

        .student-btn-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: #0f172a;
            padding: .85rem 1.25rem;
            font-size: 1rem;
            font-weight: 800;
            color: #ffffff;
            transition: all .15s ease;
            text-decoration: none;
        }

        .student-btn-dark:hover {
            background: #020617;
        }

        .student-mini-card {
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            background: #ffffff;
            padding: 1.25rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .student-doc-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #f8fafc;
            padding: 1rem;
        }

        .student-doc-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #1d4ed8;
            padding: .55rem .9rem;
            font-size: .9rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
        }

        .student-doc-link:hover {
            background: #1e40af;
        }

        .student-timeline-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 2.75rem;
            width: 2.75rem;
            border-radius: 999px;
            font-size: 1rem;
            font-weight: 900;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
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

            .student-top-btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 14px;
                background: #1d4ed8;
                padding: .85rem 1.25rem;
                font-size: 1rem;
                font-weight: 800;
                color: #ffffff;
                transition: all .15s ease;
                text-decoration: none;
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.05);
            }

            .student-top-btn-primary:hover {
                background: #1e40af;
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

            .student-top-btn-dark {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 14px;
                background: #0f172a;
                padding: .85rem 1.25rem;
                font-size: 1rem;
                font-weight: 800;
                color: #ffffff;
                transition: all .15s ease;
                text-decoration: none;
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.05);
            }

            .student-top-btn-dark:hover {
                background: #020617;
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
                            Postulación
                        </div>

                        <h1 class="student-top-title">
                            <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                                Detalle de postulación #{{ $postulacion->id }}
                            </span>
                        </h1>

                        <p class="student-top-description">
                            Revisa el estado actual, los documentos cargados y el historial de movimientos de tu postulación.
                        </p>

                        <p class="student-top-note">
                            Última actualización:
                            {{ optional($postulacion->updated_at)->timezone('America/Bogota')->format('Y-m-d H:i') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('student.postulaciones.index') }}"
                           class="student-top-btn-primary">
                            Ver mis postulaciones
                        </a>

                        <a href="{{ route('student.dashboard') }}"
                           class="student-top-btn-secondary">
                            Volver al dashboard
                        </a>

                        @if (in_array(($postulacion->estado ?? ''), ['Postulado', 'Pendiente'], true))
                            <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                               class="student-top-btn-dark">
                                Editar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $estado = $postulacion->estado ?? 'Postulado';

        $badge = match ($estado) {
            'Postulado' => 'bg-amber-50 text-amber-800 border-amber-200',
            'Pendiente' => 'bg-amber-50 text-amber-800 border-amber-200',
            'En estudio' => 'bg-blue-50 text-blue-800 border-blue-200',
            'Pendiente aprobación gerencia' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
            'Aprobado' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
            'Rechazado' => 'bg-red-50 text-red-800 border-red-200',
            'Cancelado' => 'bg-slate-100 text-slate-700 border-slate-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };

        $tipo = $postulacion->tipo_postulacion ?? 'primer_semestre';

        $tipoLabel = match ($tipo) {
            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
            'otro_semestre' => 'Ingreso a otro semestre (primera vez)',
            'renovacion' => 'Renovación (ya becado)',
            'becado_actual' => 'Becado actual',
            default => 'N/D',
        };

        $pendientes = [];

        if ($tipo === 'renovacion') {
            if (empty($postulacion->anexo_certificado_notas)) {
                $pendientes[] = 'Certificado de notas';
            }

            if (empty($postulacion->anexo_recibo_matricula)) {
                $pendientes[] = 'Recibo de matrícula';
            }

            if (($postulacion->cuenta_actualizada ?? false) && empty($postulacion->anexo_certificado_bancario)) {
                $pendientes[] = 'Certificado cuenta bancaria';
            }
        } else {
            if (empty($postulacion->anexo_doc_identidad)) {
                $pendientes[] = 'Documento de identidad';
            }

            if (empty($postulacion->anexo_foto_documento)) {
                $pendientes[] = 'Foto tipo documento';
            }

            if (empty($postulacion->anexo_certificado_bancario)) {
                $pendientes[] = 'Certificado cuenta bancaria';
            }

            if (empty($postulacion->pdf_notas)) {
                $pendientes[] = 'PDF Notas';
            }

            if (empty($postulacion->pdf_matricula)) {
                $pendientes[] = 'PDF Matrícula';
            }

            if (is_null($postulacion->promedio_carrera)) {
                $pendientes[] = 'Promedio de carrera';
            }
        }

        if ($estado === 'Rechazado') {
            $etapas = ['Postulado', 'En estudio', 'Pendiente aprobación gerencia', 'Rechazado'];
        } elseif ($estado === 'Cancelado') {
            $etapas = ['Postulado', 'Cancelado'];
        } else {
            $etapas = ['Postulado', 'En estudio', 'Pendiente aprobación gerencia', 'Aprobado'];
        }

        $indiceEstado = array_search($estado, $etapas, true);
        $indiceEstado = ($indiceEstado === false) ? 0 : $indiceEstado;

        $generoLabel = $postulacion->genero ?: 'N/D';

        $fileUrl = fn(string $field) => route('student.postulaciones.file', [$postulacion, $field]);

        $promedio = $postulacion->promedio_universitario ?? $postulacion->promedio_carrera;

        $semestresPromedios = $postulacion->semestres_promedios;

        if (is_string($semestresPromedios)) {
            $semestresPromedios = json_decode($semestresPromedios, true);
        }

        if (! is_array($semestresPromedios)) {
            $semestresPromedios = [];
        }
    @endphp

    <div class="student-show-page min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 space-y-8">

            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-base font-semibold text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="student-show-card">
                <div class="p-6 sm:p-8 space-y-8">

                    {{-- Tarjetas resumen --}}
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div class="student-mini-card">
                            <div class="student-label">Estado</div>
                            <div class="mt-3">
                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-sm font-bold {{ $badge }}">
                                    {{ $estado }}
                                </span>
                            </div>
                        </div>

                        <div class="student-mini-card">
                            <div class="student-label">Tipo</div>
                            <div class="student-value">
                                {{ $tipoLabel }}
                            </div>
                        </div>

                        <div class="student-mini-card">
                            <div class="student-label">Última actualización</div>
                            <div class="student-value">
                                {{ optional($postulacion->updated_at)->timezone('America/Bogota')->format('Y-m-d H:i') }}
                            </div>
                        </div>

                        <div class="student-mini-card">
                            <div class="student-label">Pendientes</div>
                            <div class="student-value">
                                {{ count($pendientes) }}
                            </div>
                        </div>
                    </div>

                    {{-- Pendientes --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Pendientes o incompletos
                        </div>

                        @if (count($pendientes) === 0)
                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-base font-bold text-emerald-700">
                                ¡Todo completo! No tienes pendientes.
                            </div>
                        @else
                            <ul class="space-y-2 text-base text-slate-700">
                                @foreach ($pendientes as $p)
                                    <li class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                        {{ $p }}
                                    </li>
                                @endforeach
                            </ul>

                            @if (in_array(($postulacion->estado ?? ''), ['Postulado', 'Pendiente'], true))
                                <div class="mt-4">
                                    <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                                       class="student-btn-dark">
                                        Completar información
                                    </a>
                                </div>
                            @else
                                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-base leading-7 text-slate-600">
                                    Esta solicitud ya inició revisión por parte de la Fundación. Si necesitas actualizar información o documentos, contacta a coordinación.
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Timeline --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Estado del proceso
                        </div>

                        @if ($estado === 'Rechazado')
                            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-base leading-7 text-red-700">
                                Tu postulación fue rechazada. Si necesitas aclaraciones, revisa el perfil descriptivo o contacta a la Fundación.
                            </div>
                        @endif

                        @if ($estado === 'Cancelado')
                            <div class="mb-5 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-base leading-7 text-slate-700">
                                Tu postulación fue cancelada y no continuará el proceso.
                            </div>
                        @endif

                        <ol class="mt-6 flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                            @foreach ($etapas as $i => $etapa)
                                @php
                                    $completa = ($indiceEstado >= $i);
                                    $actual = ($estado === $etapa);

                                    $circle = match ($etapa) {
                                        'Aprobado' => $completa ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500',
                                        'Rechazado' => $completa ? 'bg-red-600 text-white' : 'bg-slate-200 text-slate-500',
                                        'Cancelado' => $completa ? 'bg-slate-700 text-white' : 'bg-slate-200 text-slate-500',
                                        'Pendiente aprobación gerencia' => $completa ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500',
                                        default => $completa ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-500',
                                    };
                                @endphp

                                <li class="relative flex-1">
                                    <div class="flex gap-4 md:flex-col md:items-center">
                                        <div class="student-timeline-circle {{ $circle }}">
                                            {{ $i + 1 }}
                                        </div>

                                        <div class="text-base font-black {{ $completa ? 'text-slate-900' : 'text-slate-400' }} md:text-center">
                                            {{ $etapa }}

                                            @if ($actual)
                                                <span class="mt-1 block text-sm font-bold text-blue-700">
                                                    Etapa actual
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                        <p class="mt-6 text-sm leading-6 text-slate-500">
                            Las etapas pueden avanzar según revisión de coordinación y decisión de gerencia.
                        </p>
                    </div>

                    {{-- Datos del estudiante + foto --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Datos del estudiante
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3 md:items-start">
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <div class="student-label">Nombre</div>
                                        <div class="student-value">{{ $postulacion->estudiante_nombre }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Email</div>
                                        <div class="student-value">{{ $postulacion->estudiante_email ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Fecha de nacimiento</div>
                                        <div class="student-value">
                                            {{ $postulacion->fecha_nacimiento ? \Carbon\Carbon::parse($postulacion->fecha_nacimiento)->format('d/m/Y') : 'N/D' }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="student-label">Tipo de documento</div>
                                        <div class="student-value">{{ $postulacion->tipo_documento ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Documento de identidad</div>
                                        <div class="student-value">{{ $postulacion->documento_identidad ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Teléfono celular</div>
                                        <div class="student-value">{{ $postulacion->telefono_celular ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Teléfono fijo</div>
                                        <div class="student-value">{{ $postulacion->telefono_fijo ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Dirección</div>
                                        <div class="student-value">{{ $postulacion->direccion ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Barrio</div>
                                        <div class="student-value">{{ $postulacion->barrio ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="student-label">Género</div>
                                        <div class="student-value">{{ $generoLabel }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-center md:justify-end">
                                @if (!empty($postulacion->anexo_foto_documento))
                                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-2 shadow-sm">
                                        <img
                                            src="{{ $fileUrl('anexo_foto_documento') }}"
                                            alt="Foto tipo documento"
                                            class="h-auto w-44 rounded-xl object-cover sm:w-60"
                                        >
                                    </div>
                                @else
                                    <div class="flex h-44 w-44 items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 text-center text-sm font-semibold text-slate-400">
                                        Sin foto tipo documento
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Acudiente --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Datos del acudiente
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <div class="student-label">Nombre</div>
                                <div class="student-value">{{ $postulacion->nombre_acudiente ?: 'N/D' }}</div>
                            </div>

                            <div>
                                <div class="student-label">Teléfono</div>
                                <div class="student-value">{{ $postulacion->telefono_acudiente ?: 'N/D' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Estudios --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Estudios
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @if ($tipo === 'primer_semestre')
                                <div>
                                    <div class="student-label">Universidad a la que aplica</div>
                                    <div class="student-value">{{ $postulacion->universidad_aplica ?: 'N/D' }}</div>
                                </div>

                                <div>
                                    <div class="student-label">Carrera</div>
                                    <div class="student-value">{{ $postulacion->carrera_aplica ?: 'N/D' }}</div>
                                </div>
                            @else
                                <div>
                                    <div class="student-label">Universidad actual</div>
                                    <div class="student-value">{{ $postulacion->universidad_actual ?: 'N/D' }}</div>
                                </div>

                                <div>
                                    <div class="student-label">Carrera actual</div>
                                    <div class="student-value">{{ $postulacion->carrera_actual ?: 'N/D' }}</div>
                                </div>

                                <div>
                                    <div class="student-label">Semestre en curso</div>
                                    <div class="student-value">{{ $postulacion->semestre_en_curso ?: 'N/D' }}</div>
                                </div>
                            @endif

                            <div>
                                <div class="student-label">Promedio universitario</div>
                                <div class="student-value {{ filled($promedio) && (float) $promedio >= 3.8 ? 'text-emerald-700' : 'text-red-700' }}">
                                    {{ filled($promedio) ? number_format((float) $promedio, 2) : 'N/D' }}
                                </div>
                            </div>
                        </div>

                        @if (count($semestresPromedios) > 0)
                            <div class="mt-6 border-t border-slate-200 pt-5">
                                <h4 class="mb-3 text-base font-black text-slate-900">
                                    Promedios por semestre
                                </h4>

                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($semestresPromedios as $item)
                                        @php
                                            $promedioSemestre = isset($item['promedio_acumulado'])
                                                ? (float) $item['promedio_acumulado']
                                                : null;

                                            $clasePromedio = $promedioSemestre !== null && $promedioSemestre >= 3.8
                                                ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                                : 'border-red-200 bg-red-50 text-red-700';
                                        @endphp

                                        <div class="rounded-2xl border p-4 {{ $clasePromedio }}">
                                            <div class="text-sm font-black">
                                                Semestre {{ $item['semestre'] ?? 'N/D' }}
                                            </div>

                                            <div class="mt-1 text-2xl font-black">
                                                {{ $promedioSemestre !== null ? number_format($promedioSemestre, 2) : 'N/D' }}
                                            </div>

                                            <div class="mt-1 text-xs font-bold opacity-80">
                                                Promedio acumulado
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Datos bancarios --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Datos bancarios
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <div class="student-label">Banco</div>
                                <div class="student-value">{{ $postulacion->banco ?: 'N/D' }}</div>
                            </div>

                            <div>
                                <div class="student-label">Titular</div>
                                <div class="student-value">{{ $postulacion->titular_cuenta ?: 'N/D' }}</div>
                            </div>

                            <div>
                                <div class="student-label">Tipo de cuenta</div>
                                <div class="student-value">{{ $postulacion->tipo_cuenta ?: 'N/D' }}</div>
                            </div>

                            <div>
                                <div class="student-label">Número de cuenta</div>
                                <div class="student-value">{{ $postulacion->numero_cuenta ?: 'N/D' }}</div>
                            </div>

                            @if ($tipo === 'renovacion')
                                <div class="sm:col-span-2">
                                    <div class="student-label">Cuenta actualizada</div>
                                    <div class="student-value">
                                        {{ $postulacion->cuenta_actualizada ? 'Sí' : 'No' }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Información adicional
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-base leading-7 text-slate-700 whitespace-pre-line">
                            {{ $postulacion->como_encontro ?: 'Sin respuesta.' }}
                        </div>
                    </div>

                    {{-- Perfil descriptivo --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Perfil descriptivo
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-base leading-7 text-slate-700 whitespace-pre-line">
                            {{ $postulacion->perfil_descriptivo ?? 'Aún no hay perfil descriptivo registrado.' }}
                        </div>
                    </div>

                    {{-- Documentos --}}
                    <div class="student-section">
                        <div class="student-section-title">
                            Documentos
                        </div>

                        @php
                            $docs = [];

                            if ($tipo !== 'renovacion') {
                                $docs[] = ['label' => 'Documento de identidad', 'field' => 'anexo_doc_identidad'];
                                $docs[] = ['label' => 'Foto tipo documento', 'field' => 'anexo_foto_documento'];
                                $docs[] = ['label' => 'Certificado bancario', 'field' => 'anexo_certificado_bancario'];
                                $docs[] = ['label' => 'Notas académicas', 'field' => 'pdf_notas'];
                                $docs[] = ['label' => 'Recibo de matrícula', 'field' => 'pdf_matricula'];
                            } else {
                                $docs[] = ['label' => 'Certificado de notas', 'field' => 'anexo_certificado_notas'];
                                $docs[] = ['label' => 'Recibo matrícula', 'field' => 'anexo_recibo_matricula'];

                                if ($postulacion->cuenta_actualizada) {
                                    $docs[] = ['label' => 'Certificado bancario', 'field' => 'anexo_certificado_bancario'];
                                }
                            }
                        @endphp

                        <div class="space-y-3">
                            @foreach ($docs as $d)
                                @php
                                    $path = $postulacion->{$d['field']} ?? null;
                                @endphp

                                <div class="student-doc-row">
                                    <div class="min-w-0">
                                        <div class="text-base font-black text-slate-900">
                                            {{ $d['label'] }}
                                        </div>

                                        <div class="mt-1 truncate text-sm font-semibold text-slate-500">
                                            {{ $path ? basename($path) : 'No adjuntado' }}
                                        </div>
                                    </div>

                                    @if ($path)
                                        <a href="{{ $fileUrl($d['field']) }}"
                                           target="_blank"
                                           rel="noopener"
                                           class="student-doc-link">
                                            Ver
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{-- Historial --}}
            @if (method_exists($postulacion, 'historicoEstados') && $postulacion->relationLoaded('historicoEstados'))
                <div class="student-show-card">
                    <div class="p-6 sm:p-8">
                        <div class="student-section-title">
                            Historial de cambios
                        </div>

                        @if ($postulacion->historicoEstados->isEmpty())
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-base text-slate-600">
                                No hay historial registrado.
                            </div>
                        @else
                            <ol class="space-y-4">
                                @foreach ($postulacion->historicoEstados as $h)
                                    <li class="flex gap-3">
                                        <div class="mt-2 h-2.5 w-2.5 rounded-full bg-blue-700"></div>

                                        <div class="flex-1">
                                            <div class="text-base font-black text-slate-900">
                                                {{ $h->estado_nuevo }}

                                                @if ($h->estado_anterior)
                                                    <span class="font-semibold text-slate-500">
                                                        (antes: {{ $h->estado_anterior }})
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="text-sm font-semibold text-slate-500">
                                                {{ \Carbon\Carbon::parse($h->cambiado_en)->timezone('America/Bogota')->format('Y-m-d H:i') }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>