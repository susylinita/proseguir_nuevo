<x-app-layout>

    <style>
        .student-index-page {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #0f172a;
        }

        .student-index-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .student-section-title {
            font-size: 1.35rem;
            line-height: 1.8rem;
            font-weight: 900;
            color: #0f172a;
        }

        .student-section-description {
            margin-top: .35rem;
            font-size: 1rem;
            line-height: 1.6rem;
            color: #64748b;
        }

        .student-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .student-table th {
            padding: 1rem;
            text-align: left;
            font-size: .85rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .student-table td {
            padding: 1rem;
            font-size: 1rem;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
        }

        .student-table tbody tr:hover {
            background: #f8fafc;
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
        }

        .student-btn-secondary:hover {
            background: #f8fafc;
        }

        .student-action-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            border-radius: 12px;
            padding: .55rem .9rem;
            font-size: .9rem;
            font-weight: 800;
            transition: all .15s ease;
        }

        .student-empty {
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            border-radius: 22px;
            padding: 2rem;
            text-align: center;
        }
    </style>

    @if ($errors->has('general'))
        <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
                <strong>Solicitud bloqueada.</strong>
                <p class="mt-1">{{ $errors->first('general') }}</p>
                <p class="mt-1">Por favor, contacta al administrador.</p>
            </div>
        </div>
    @endif

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
                        Gestión de solicitudes
                    </div>

                    <h1 class="student-top-title">
                        <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                            Mis postulaciones
                        </span>
                    </h1>

                    <p class="student-top-description">
                        Consulta el estado de tus solicitudes, revisa avances y administra tus documentos adjuntos.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if (! auth()->user()?->becas_bloqueado)
                        <a href="{{ route('student.postulaciones.create') }}"
                           class="student-top-btn-primary">
                            + Nueva postulación
                        </a>
                    @endif

                    <a href="{{ route('student.dashboard') }}"
                       class="student-top-btn-secondary">
                        ← Volver al dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-slot>

    <div class="student-index-page py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="student-index-card">
                <div class="border-b border-slate-200 p-6">
                    <h2 class="student-section-title">
                        Historial de postulaciones
                    </h2>

                    <p class="student-section-description">
                        Aquí puedes revisar tus solicitudes registradas, su estado actual y acceder al detalle.
                    </p>
                </div>

                <div class="p-6">
                    @if ($postulaciones->isEmpty())
                        <div class="student-empty">
                            <div class="text-4xl">
                                📄
                            </div>

                            <h3 class="mt-4 text-xl font-black text-slate-900">
                                Aún no tienes postulaciones registradas
                            </h3>

                            <p class="mt-2 text-base leading-7 text-slate-600">
                                Cuando crees tu primera postulación, aparecerá aquí con su estado y acciones disponibles.
                            </p>

                            @if (! auth()->user()?->becas_bloqueado)
                                <div class="mt-6">
                                    <a href="{{ route('student.postulaciones.create') }}"
                                       class="student-btn-primary">
                                        Crear primera postulación
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="student-table min-w-full">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Actualizado</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($postulaciones as $postulacion)
                                        @php
                                            $estado = $postulacion->estado ?? 'N/D';

                                            $estadoBadge = match ($estado) {
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
                                                'primer_semestre' => 'Primer semestre',
                                                'otro_semestre' => 'Otro semestre',
                                                'renovacion' => 'Renovación',
                                                'becado_actual' => 'Becado actual',
                                                default => 'N/D',
                                            };

                                            $tipoBadge = match ($tipo) {
                                                'primer_semestre' => 'bg-purple-50 text-purple-800 border-purple-200',
                                                'otro_semestre' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                                                'renovacion' => 'bg-teal-50 text-teal-800 border-teal-200',
                                                'becado_actual' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                                            };
                                        @endphp

                                        <tr>
                                            <td class="font-black text-slate-900">
                                                #{{ $postulacion->id }}
                                            </td>

                                            <td>
                                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-sm font-bold {{ $tipoBadge }}">
                                                    {{ $tipoLabel }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-sm font-bold {{ $estadoBadge }}">
                                                    {{ $estado }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ optional($postulacion->updated_at)->format('Y-m-d H:i') }}
                                            </td>

                                            <td>
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                                                       class="student-action-link border border-slate-200 bg-slate-100 text-slate-700 hover:bg-slate-200">
                                                        👁 Ver
                                                    </a>

                                                    @if (in_array($estado, ['Pendiente', 'Postulado'], true))
                                                        <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                                                           class="student-action-link bg-blue-700 text-white hover:bg-blue-800">
                                                            ✏ Editar
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if (method_exists($postulaciones, 'links'))
                            <div class="mt-6">
                                {{ $postulaciones->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>