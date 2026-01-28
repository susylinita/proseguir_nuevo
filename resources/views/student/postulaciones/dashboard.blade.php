<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                    Mi portal · Becas
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Consulta tus postulaciones, adjunta documentos y haz seguimiento al estado.
                </p>
            </div>

        </div>
    </x-slot>

    {{-- micro-animaciones sin librerías --}}
    <style>
        @media (prefers-reduced-motion: reduce) {
            .reveal { transition: none !important; }
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
    </style>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="reveal rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Banner suave --}}
            <div class="reveal relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="absolute inset-0">
                    <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
                    <div class="absolute -top-20 -right-16 h-64 w-64 rounded-full bg-emerald-200/35 blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-16 h-64 w-64 rounded-full bg-blue-200/35 blur-3xl"></div>
                    <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-900 to-emerald-500"></div>
                </div>

                <div class="relative p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Seguimiento en tiempo real
                            </div>

                            <h3 class="mt-3 text-2xl font-extrabold tracking-tight">
                                <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                                    Estado de tus postulaciones
                                </span>
                            </h3>

                            <p class="mt-2 text-sm sm:text-base text-slate-600 max-w-2xl">
                                Revisa el historial de cambios, documentos cargados y el avance de cada solicitud.
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('student.postulaciones.index') }}"
                               class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Ver todas
                            </a>
                            <a href="{{ route('student.postulaciones.create') }}"
                               class="inline-flex items-center justify-center rounded-md bg-blue-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-900 transition">
                                Iniciar nueva
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KPIs --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="reveal rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $counts['total'] ?? 0 }}</div>
                </div>

                <div class="reveal rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pendientes</div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $counts['pendiente'] ?? 0 }}</div>
                </div>

                <div class="reveal rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Preseleccionadas</div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $counts['preseleccionado'] ?? 0 }}</div>
                </div>

                <div class="reveal rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Aprobadas</div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $counts['aprobado'] ?? 0 }}</div>
                </div>

                <div class="reveal rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Rechazadas</div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $counts['rechazado'] ?? 0 }}</div>
                </div>
            </div>

            {{-- Recientes --}}
            <div class="reveal rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="p-6 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Mis postulaciones recientes</h3>
                        <p class="mt-1 text-sm text-slate-500">Accede rápido al detalle, documentos e historial.</p>
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
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Estado</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actualizado</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acción</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach(($postulaciones ?? collect())->take(8) as $p)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3 text-sm font-semibold text-slate-900">#{{ $p->id }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-700">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold
                                                @if(($p->estado ?? '') === 'Aprobado') bg-emerald-50 text-emerald-800
                                                @elseif(($p->estado ?? '') === 'Rechazado') bg-red-50 text-red-800
                                                @elseif(($p->estado ?? '') === 'Preseleccionado') bg-blue-50 text-blue-800
                                                @else bg-slate-100 text-slate-800
                                                @endif
                                            ">
                                                {{ $p->estado ?? 'N/D' }}
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
                <div class="reveal rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-xs font-semibold text-blue-800">Paso 1</div>
                    <div class="mt-2 font-semibold text-slate-900">Crea tu postulación</div>
                    <div class="mt-1 text-sm text-slate-600">Completa puntajes y adjunta PDFs si aplica.</div>
                </div>

                <div class="reveal rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-xs font-semibold text-emerald-700">Paso 2</div>
                    <div class="mt-2 font-semibold text-slate-900">Revisión</div>
                    <div class="mt-1 text-sm text-slate-600">Coordinación actualiza el estado y comentarios.</div>
                </div>

                <div class="reveal rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-xs font-semibold text-slate-700">Paso 3</div>
                    <div class="mt-2 font-semibold text-slate-900">Seguimiento</div>
                    <div class="mt-1 text-sm text-slate-600">Consulta historial y novedades desde el detalle.</div>
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
