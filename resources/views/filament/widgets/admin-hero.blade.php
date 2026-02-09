@php
    $user = filament()->auth()->user();
    $name = $user?->name ?? 'Usuario';
@endphp

<x-filament::section class="w-full">
    <div class="relative overflow-hidden rounded-2xl">
        {{-- Fondo --}}
        <div class="absolute inset-0">
            <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
            <div class="absolute -top-24 -right-24 h-80 w-80 rounded-full bg-emerald-200/35 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-blue-200/35 blur-3xl"></div>
            <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-900 to-emerald-500"></div>
        </div>

        {{-- Contenido --}}
        <div class="relative p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                {{-- Texto --}}
                <div class="min-w-0">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Panel de Coordinación / Gerencia
                    </div>

                    <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight">
                        <span class="text-slate-900">Hola,</span>
                        <span class="text-blue-900">{{ $name }}</span>
                    </h2>

                    <p class="mt-2 text-sm sm:text-base text-slate-600 max-w-3xl">
                        Revisa postulaciones en <b>Pendiente</b> y <b>Entrevista</b>, valida documentos, registra observaciones
                        y genera reportes con trazabilidad del último movimiento.
                    </p>

                    <p class="mt-4 text-xs text-slate-500">
                        {{ now()->format('Y-m-d H:i') }} · Fundación Proseguir
                    </p>
                </div>

                {{-- Acciones --}}
                <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                    <x-filament::button
                        tag="a"
                        href="{{ route('filament.admin.resources.postulacions.index') }}"
                        color="primary"
                        size="lg"
                    >
                        Ver postulaciones
                    </x-filament::button>

                    <x-filament::button
                        tag="a"
                        href="{{ url()->current() }}"
                        color="gray"
                        size="lg"
                    >
                        Refrescar dashboard
                    </x-filament::button>
                </div>

            </div>
        </div>
    </div>
</x-filament::section>
