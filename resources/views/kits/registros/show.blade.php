<x-app-kits-layout>

    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="rounded-2xl p-8 
                    bg-gradient-to-r from-slate-100 via-slate-200 to-emerald-100 
                    border border-slate-200 shadow-sm">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                <div>
                    <div class="inline-flex items-center gap-2 
                                px-4 py-1.5 rounded-full 
                                bg-white/70 backdrop-blur 
                                border border-slate-300 
                                text-xs font-medium text-slate-700 shadow-sm">
                        📄 Detalle del registro
                    </div>

                    <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-slate-900">
                        Solicitud de Kit Escolar
                    </h1>

                    <p class="mt-3 text-slate-600 max-w-2xl">
                        Información completa del registro realizado.
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('kits.dashboard') }}"
                       class="inline-flex items-center gap-2 
                              bg-white border border-slate-300 
                              text-slate-700 px-6 py-3 
                              rounded-xl font-medium 
                              hover:bg-slate-50 transition">
                        ← Volver al dashboard
                    </a>
                </div>

            </div>
        </div>
    </x-slot>


    {{-- ================= CONTENIDO ================= --}}
    <div class="py-10">
        <div class="max-w-5xl mx-auto px-6">

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Línea superior --}}
                <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-indigo-700 via-slate-900 to-emerald-500"></div>

                <div class="p-10 space-y-10 text-slate-900">

                    {{-- ================= ESTADO ================= --}}
                    @php
                        $color = match($registro->estado) {
                            'Aprobado' => 'bg-green-100 text-green-800',
                            'Rechazado' => 'bg-red-100 text-red-800',
                            'Entregado' => 'bg-blue-100 text-blue-800',
                            default => 'bg-yellow-100 text-yellow-800',
                        };
                    @endphp

                    <div class="flex justify-between items-center border-b border-slate-200 pb-6">
                        <div>
                            <p class="text-sm text-slate-500">Estado actual</p>
                            <span class="inline-flex px-3 py-1 mt-2 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $registro->estado }}
                            </span>
                        </div>

                        <div class="text-right text-sm text-slate-500">
                            Creado: {{ $registro->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>


                    {{-- ================= COLABORADOR ================= --}}
                    <div class="space-y-6">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">
                            Información del colaborador
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                            <div>
                                <p class="text-slate-500">Nombre completo</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->colaborador_nombre }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500">Documento</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->colaborador_documento }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500">Línea de negocio</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->linea_negocio }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500">Área</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->area }}
                                </p>
                            </div>

                        </div>
                    </div>


                    {{-- ================= NIÑO ================= --}}
                    <div class="space-y-6 pt-6 border-t border-slate-200">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">
                            Información del niño
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                            <div>
                                <p class="text-slate-500">Nombre completo</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->nino_nombre }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500">Documento</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->nino_documento }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500">Edad</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->edad }} años
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500">Grado</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->grado }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-slate-500">Institución</p>
                                <p class="font-medium text-slate-900 mt-1">
                                    {{ $registro->institucion }}
                                </p>
                            </div>

                        </div>
                    </div>


                    {{-- ================= OBSERVACIONES ================= --}}
                    @if($registro->observaciones)
                        <div class="space-y-3 pt-6 border-t border-slate-200">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">
                                Observaciones
                            </h3>

                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-5 text-sm text-slate-700 whitespace-pre-line">
                                {{ $registro->observaciones }}
                            </div>
                        </div>
                    @endif


                    {{-- ================= BOTONES ================= --}}
                    <div class="flex justify-end gap-4 pt-8 border-t border-slate-200">

                        @if($registro->estado === 'Pendiente')
                            <a href="{{ route('kits.registros.edit', $registro) }}"
                               class="inline-flex items-center rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition shadow-sm">
                                Editar registro
                            </a>
                        @endif

                        <a href="{{ route('kits.dashboard') }}"
                           class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-6 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                            Volver
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-kits-layout>
