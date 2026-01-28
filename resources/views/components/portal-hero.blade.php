@props([
    'badge' => 'Seguimiento en tiempo real',
    'title' => 'Estado',
    'description' => null,

    // Botón 1
    'primaryLabel' => null,
    'primaryHref' => null,
    'primaryClass' => 'bg-blue-800 hover:bg-blue-900',

    // Botón 2
    'secondaryLabel' => null,
    'secondaryHref' => null,
])

<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm">
            <div class="h-1 bg-gradient-to-r from-blue-800 via-slate-800 to-emerald-500"></div>

            <div class="p-6 sm:p-7 bg-gradient-to-r from-blue-50 via-white to-emerald-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            {{ $badge }}
                        </span>

                        <h1 class="mt-3 text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                            {{ $title }}
                        </h1>

                        @if($description)
                            <p class="mt-2 text-sm sm:text-base text-slate-600">
                                {{ $description }}
                            </p>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        @if($secondaryLabel && $secondaryHref)
                            <a href="{{ $secondaryHref }}"
                               class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                                {{ $secondaryLabel }}
                            </a>
                        @endif

                        @if($primaryLabel && $primaryHref)
                            <a href="{{ $primaryHref }}"
                               class="inline-flex items-center justify-center rounded-md px-5 py-2.5 text-sm font-semibold text-white transition {{ $primaryClass }}">
                                {{ $primaryLabel }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
