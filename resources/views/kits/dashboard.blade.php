<x-app-kits-layout>

    {{-- HERO (como Becas) --}}
    <x-portal-hero
        badge="Seguimiento en tiempo real"
        title="Estado de tus beneficiarios"
        description="Revisa registros, documentos cargados y el avance del proceso."
        secondaryLabel="Ver todas"
        secondaryHref="{{ route('kits.registros.index') }}"
        primaryLabel="+ Nuevo registro"
        primaryHref="{{ route('kits.registros.create') }}"
        primaryClass="bg-blue-800 hover:bg-blue-900"
    />

    <div class="bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

            {{-- KPI CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @php
                    $kpis = [
                        ['label' => 'Total', 'value' => $counts['total'], 'tone' => 'slate'],
                        ['label' => 'Pendiente', 'value' => $counts['pendiente'], 'tone' => 'amber'],
                        ['label' => 'Aprobado', 'value' => $counts['aprobado'], 'tone' => 'emerald'],
                        ['label' => 'Rechazado', 'value' => $counts['rechazado'], 'tone' => 'rose'],
                        ['label' => 'Entregado', 'value' => $counts['entregado'], 'tone' => 'blue'],
                    ];

                    $toneMap = [
                        'slate' => ['bg' => 'bg-slate-50', 'text' => 'text-slate-900', 'pill' => 'bg-slate-100 text-slate-700'],
                        'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-900', 'pill' => 'bg-amber-100 text-amber-800'],
                        'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-900', 'pill' => 'bg-emerald-100 text-emerald-800'],
                        'rose' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-900', 'pill' => 'bg-rose-100 text-rose-800'],
                        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-900', 'pill' => 'bg-blue-100 text-blue-800'],
                    ];
                @endphp

                @foreach($kpis as $k)
                    @php $t = $toneMap[$k['tone']]; @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    {{ $k['label'] }}
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $t['pill'] }}">
                                    {{ $k['label'] }}
                                </span>
                            </div>

                            <div class="mt-3 text-3xl font-bold {{ $t['text'] }}">
                                {{ $k['value'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- TABLE CARD --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="p-6 sm:p-7">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Mis registros</h3>
                            <p class="mt-1 text-sm text-slate-600">Accede rápido al detalle y estado de cada registro.</p>
                        </div>


                    </div>

                    @if ($registros->isEmpty())
                        <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-6 text-slate-700">
                            Aún no has registrado niños para kits.
                        </div>
                    @else
                        <div class="mt-5 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Niño</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Estado</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actualizado</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-slate-100">
                                    @foreach ($registros->take(8) as $r)
                                        @php
                                            $estado = strtolower($r->estado ?? '');
                                            $badgeClass = match(true) {
                                                str_contains($estado, 'pend') => 'bg-amber-50 text-amber-800 ring-1 ring-amber-200',
                                                str_contains($estado, 'aprob') => 'bg-emerald-50 text-emerald-800 ring-1 ring-emerald-200',
                                                str_contains($estado, 'rech') => 'bg-rose-50 text-rose-800 ring-1 ring-rose-200',
                                                str_contains($estado, 'entre') => 'bg-blue-50 text-blue-800 ring-1 ring-blue-200',
                                                default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                                            };
                                        @endphp

                                        <tr class="hover:bg-slate-50/60">
                                            <td class="px-4 py-3 text-sm font-semibold text-slate-900">
                                                {{ $r->nino_nombre }}
                                            </td>

                                            <td class="px-4 py-3 text-sm text-slate-700">
                                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClass }}">
                                                    {{ $r->estado }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-sm text-slate-600">
                                                {{ optional($r->updated_at)->format('Y-m-d H:i') }}
                                            </td>

                                            <td class="px-4 py-3 text-sm text-right">
                                                <a class="font-semibold text-blue-800 hover:text-blue-900"
                                                   href="{{ route('kits.registros.show', $r) }}">
                                                    Ver →
                                                </a>

                                                @if (!in_array($r->estado, ['Aprobado','Rechazado','Entregado']))
                                                    <span class="text-slate-300 mx-2">|</span>
                                                    <a class="font-semibold text-slate-700 hover:text-slate-900"
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
