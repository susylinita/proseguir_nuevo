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
                        📄 Mis registros
                    </div>

                    <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-slate-900">
                        Mis registros de Kits
                    </h1>

                    <p class="mt-3 text-slate-600 max-w-2xl">
                        Aquí puedes consultar el estado de tus solicitudes registradas.
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

                    <a href="{{ route('kits.registros.create') }}"
                       class="inline-flex items-center 
                              rounded-xl bg-slate-900 
                              px-6 py-3 text-sm font-semibold text-white 
                              hover:bg-slate-700 transition shadow-sm">
                        + Registrar niño
                    </a>
                </div>

            </div>
        </div>
    </x-slot>


    {{-- ================= CONTENIDO ================= --}}
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-6">

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Línea superior --}}
                <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-indigo-700 via-slate-900 to-emerald-500"></div>

                <div class="p-8">

                    @if (session('status'))
                        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($registros->isEmpty())
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-slate-600">
                            Aún no has registrado niños para kits escolares.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">

                                <thead>
                                    <tr class="border-b border-slate-200 text-left text-xs uppercase text-slate-500 tracking-wide">
                                        <th class="px-4 py-3">Niño</th>
                                        <th class="px-4 py-3">Estado</th>
                                        <th class="px-4 py-3">Actualizado</th>
                                        <th class="px-4 py-3 text-right">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($registros as $r)

                                        @php
                                            $badgeColor = match($r->estado) {
                                                'Aprobado' => 'bg-green-100 text-green-800',
                                                'Rechazado' => 'bg-red-100 text-red-800',
                                                'Entregado' => 'bg-blue-100 text-blue-800',
                                                default => 'bg-yellow-100 text-yellow-800',
                                            };
                                        @endphp

                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-4 py-4">
                                                <div class="font-medium text-slate-900">
                                                    {{ $r->nino_nombre }}
                                                </div>

                                                @if($r->grado || $r->institucion)
                                                    <div class="text-xs text-slate-500 mt-1">
                                                        {{ $r->grado ? 'Grado: '.$r->grado : '' }}
                                                        {{ ($r->grado && $r->institucion) ? ' • ' : '' }}
                                                        {{ $r->institucion ?? '' }}
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="px-4 py-4">
                                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                                    {{ $r->estado }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-4 text-slate-600">
                                                {{ optional($r->updated_at)->format('d/m/Y H:i') }}
                                            </td>

                                            <td class="px-4 py-4 text-right space-x-3">
                                                <a class="text-indigo-600 hover:text-indigo-900 font-medium"
                                                   href="{{ route('kits.registros.show', $r) }}">
                                                    Ver
                                                </a>

                                                @if (!in_array($r->estado, ['Aprobado','Rechazado','Entregado']))
                                                    <span class="text-slate-300">|</span>
                                                    <a class="text-slate-700 hover:text-slate-900 font-medium"
                                                       href="{{ route('kits.registros.edit', $r) }}">
                                                        Editar
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-kits-layout>
