<x-app-layout>

    {{-- micro-animaciones sin librerías --}}
    {{-- Estilos visuales del portal del postulante --}}
<style>
    .student-dashboard-page {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        color: #0f172a;
    }

    @media (prefers-reduced-motion: reduce) {
        .reveal {
            transition: none !important;
        }
    }

    .reveal {
        opacity: 0;
        transform: translateY(14px);
        transition: opacity .6s ease, transform .6s ease;
        will-change: opacity, transform;
    }

    .reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .student-hero {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
    }

    .student-hero-content {
        position: relative;
        padding: 2rem;
    }

    .student-badge {
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
    }

    .student-title {
        margin-top: 1rem;
        font-size: 2rem;
        line-height: 2.4rem;
        font-weight: 900;
        letter-spacing: -0.035em;
        color: #0f172a;
    }

    .student-description {
        margin-top: .75rem;
        max-width: 46rem;
        font-size: 1.05rem;
        line-height: 1.75rem;
        color: #64748b;
    }

    .student-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
    }

    .student-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 1.4rem;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .student-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.08);
    }

    .student-kpi-label {
        font-size: .9rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #64748b;
    }

    .student-kpi-value {
        margin-top: .65rem;
        font-size: 2.25rem;
        line-height: 2.5rem;
        font-weight: 900;
        color: #0f172a;
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

    .student-table th {
        padding: 1rem;
        text-align: left;
        font-size: .85rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #64748b;
        background: #f8fafc;
    }

    .student-table td {
        padding: 1rem;
        font-size: 1rem;
        color: #334155;
    }

    .student-step-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 1.5rem;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
    }

    .student-step-number {
        font-size: .9rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .student-step-title {
        margin-top: .6rem;
        font-size: 1.15rem;
        font-weight: 900;
        color: #0f172a;
    }

    .student-step-text {
        margin-top: .45rem;
        font-size: 1rem;
        line-height: 1.65rem;
        color: #64748b;
    }
</style>

    <div class="student-dashboard-page py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-7">

            @if (session('status'))
                <div class="reveal rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Banner suave --}}
<div class="reveal student-hero">
                    <div class="absolute inset-0">
                    <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
                    <div class="absolute -top-20 -right-16 h-64 w-64 rounded-full bg-emerald-200/35 blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-16 h-64 w-64 rounded-full bg-blue-200/35 blur-3xl"></div>
                    <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-900 to-emerald-500"></div>
                </div>

                <div class="student-hero-content">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                        <div class="student-badge"> 
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Seguimiento en tiempo real
                            </div>

                            <h3 class="student-title">
                                <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                                    Estado de tus postulaciones
                                </span>
                            </h3>

                            <p class="student-description">
                                Revisa el historial de cambios, documentos cargados y el avance de cada solicitud.
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('student.postulaciones.index') }}"
                            class="student-btn-secondary">
                                Ver todas
                            </a>

                            <a href="{{ route('student.postulaciones.create') }}"
                            class="student-btn-primary">
                                Iniciar nueva
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KPIs --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="reveal student-kpi-card">
                    <div class="student-kpi-label">Total</div>
                    <div class="student-kpi-value">{{ $counts['total'] ?? 0 }}</div>
                </div>

                <div class="reveal student-kpi-card">
                <div class="student-kpi-label">Postuladas</div>
                <div class="student-kpi-value">{{ $counts['postulado'] ?? 0 }}</div>
                </div>

                <div class="reveal student-kpi-card">
                    <div class="student-kpi-label">En estudio</div>
                    <div class="student-kpi-value">{{ $counts['en_estudio'] ?? 0 }}</div>
                </div>

                <div class="reveal student-kpi-card">
                    <div class="student-kpi-label">Aprobadas</div>
                    <div class="student-kpi-value">{{ $counts['aprobado'] ?? 0 }}</div>
                </div>

                <div class="reveal student-kpi-card">
                    <div class="student-kpi-label">Rechazadas</div>
                    <div class="student-kpi-value">{{ $counts['rechazado'] ?? 0 }}</div>
                </div>
            </div>

            {{-- Recientes --}}
            <div class="reveal student-card">
                <div class="p-6 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="student-section-title">Mis postulaciones recientes</h3>
                        <p class="student-section-description">Accede rápido al detalle, documentos e historial.</p>
                    </div>

                    <a href="{{ route('student.postulaciones.index') }}"
                       class="text-sm font-semibold text-blue-800 hover:text-blue-900">
                        Ver todas →
                    </a>
                </div>

                @if(($postulaciones ?? collect())->isEmpty())
                    <div class="px-6 pb-6">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-slate-700">
                            Aún no has creado postulaciones.
                            <a href="{{ route('student.postulaciones.create') }}" class="font-semibold text-blue-800 hover:text-blue-900">
                                Crear la primera →
                            </a>
                        </div>
                    </div>
                @else
                    <div class="px-6 pb-6 overflow-x-auto">
                        <table class="student-table min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tipo</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Estado</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actualizado</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acción</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach(($postulaciones ?? collect())->take(8) as $p)
                                    @php
                                        $tipoLabel = match ($p->tipo_postulacion) {
                                            'primer_semestre' => 'Primer semestre',
                                            'otro_semestre' => 'Otro semestre',
                                            'renovacion' => 'Renovación',
                                            'becado_actual' => 'Becado actual',
                                            default => 'N/D',
                                        };

                                        $estado = $p->estado ?? 'Postulado';

                                        $estadoClass = match ($estado) {
                                            'Aprobado' => 'bg-emerald-50 text-emerald-800',
                                            'Rechazado' => 'bg-red-50 text-red-800',
                                            'En estudio' => 'bg-blue-50 text-blue-800',
                                            'Cancelado' => 'bg-slate-100 text-slate-600',
                                            'Postulado' => 'bg-slate-100 text-slate-800',
                                            default => 'bg-slate-100 text-slate-800',
                                        };
                                    @endphp

                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3 text-sm font-semibold text-slate-900">
                                            #{{ $p->id }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-slate-700">
                                            {{ $tipoLabel }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-slate-700">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $estadoClass }}">
                                                {{ $estado }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-slate-700">
                                            {{ optional($p->updated_at)->format('Y-m-d H:i') }}
                                        </td>

                                        <td class="px-4 py-3 text-sm text-right">
                                            <a href="{{ route('student.postulaciones.show', $p) }}"
                                               class="font-semibold text-blue-800 hover:text-blue-900">
                                                Ver →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                @endif
            </div>

            {{-- Cómo funciona (mini) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="reveal student-step-card">
                    <div class="student-step-number text-blue-800">Paso 1</div>
                    <div class="student-step-title">Crea tu postulación</div>
                    <div class="student-step-text">Completa la información solicitada y adjunta los documentos requeridos.</div>
                </div>

                <div class="reveal student-step-card">
                    <div class="student-step-number text-blue-800">Paso 2</div>
                    <div class="student-step-title">En estudio</div>
                   <div class="student-step-text">La Fundación revisa tu documentación y gestiona el proceso de evaluación.</div>
                </div>

                <div class="reveal student-step-card">
                   <div class="student-step-number text-blue-800">Paso 3</div>
                    <div class="student-step-title">Resultado y seguimiento</div>
                    <div class="student-step-text">Consulta el avance, el resultado de la solicitud y las novedades desde el detalle.</div>
                </div>
            </div>

        </div>
    </div>

    {{-- Reveal on scroll --}}
    <script>
        (function () {
            const els = document.querySelectorAll('.reveal');
            const io = new IntersectionObserver((entries) => {
                entries.forEach((e) => {
                    if (e.isIntersecting) e.target.classList.add('is-visible');
                });
            }, { threshold: 0.12 });

            els.forEach(el => io.observe(el));
        })();
    </script>
</x-app-layout>