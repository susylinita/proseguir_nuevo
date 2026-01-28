<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detalle de postulación #{{ $postulacion->id }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Revisa el estado, documentos y el historial de tu postulación.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('student.postulaciones.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-900">
                    Volver a mis postulaciones
                </a>

                @if (($postulacion->estado ?? '') === 'Pendiente')
                    <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                       class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                        Editar
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    @php
        $estado = $postulacion->estado ?? 'N/D';

        $badge = 'bg-gray-100 text-gray-800';
        if ($estado === 'Pendiente') $badge = 'bg-yellow-100 text-yellow-800';
        if ($estado === 'Preseleccionado') $badge = 'bg-blue-100 text-blue-800';
        if ($estado === 'Aprobado') $badge = 'bg-green-100 text-green-800';
        if ($estado === 'Rechazado') $badge = 'bg-red-100 text-red-800';

        $pendientes = [];
        if (!$postulacion->pdf_notas) $pendientes[] = 'PDF de notas';
        if (!$postulacion->pdf_matricula) $pendientes[] = 'PDF de matrícula';

        // Etapas para timeline visual
        $etapas = ['Pendiente', 'Preseleccionado', 'Aprobado'];
        $rechazada = ($estado === 'Rechazado');

        $indiceEstado = array_search($estado, $etapas, true);
        $indiceEstado = ($indiceEstado === false) ? -1 : $indiceEstado;
    @endphp

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Resumen superior --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Estado</div>
                            <div class="mt-2">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badge }}">
                                    {{ $estado }}
                                </span>
                            </div>
                        </div>

                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Última actualización</div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ optional($postulacion->updated_at)->format('Y-m-d H:i') }}
                            </div>
                        </div>

                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Documentos pendientes</div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ count($pendientes) }}
                            </div>
                        </div>
                    </div>

                    {{-- Documentos pendientes (CTA) --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Documentos pendientes o incompletos</div>

                        @if (count($pendientes) === 0)
                            <div class="mt-2 text-sm text-green-700">
                                ¡Todo completo! No tienes documentos pendientes.
                            </div>
                        @else
                            <ul class="mt-2 list-disc list-inside text-sm text-gray-800">
                                @foreach ($pendientes as $p)
                                    <li>{{ $p }}</li>
                                @endforeach
                            </ul>

                            @if (($postulacion->estado ?? '') === 'Pendiente')
                                <div class="mt-3">
                                    <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                                       class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                                        Completar documentos
                                    </a>
                                </div>
                            @else
                                <div class="mt-3 text-sm text-gray-600">
                                    Tu postulación ya no está en Pendiente. Si necesitas actualizar documentos, contacta a coordinación.
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Timeline visual (por etapas) --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Estado visual</div>

                        @if ($rechazada)
                            <div class="mt-3 rounded-md bg-red-50 p-4 text-sm text-red-700">
                                Tu postulación fue rechazada. Si necesitas aclaraciones, revisa el perfil descriptivo o contacta a la Fundación.
                            </div>
                        @endif

                        <div class="mt-4">
                            <ol class="flex items-center justify-between gap-2">
                                @foreach ($etapas as $i => $etapa)
                                    @php
                                        $completa = ($indiceEstado >= $i);
                                        $actual = ($estado === $etapa);
                                        $dot = $completa ? 'bg-gray-900' : 'bg-gray-300';
                                        $txt = $completa ? 'text-gray-900' : 'text-gray-500';
                                        $line = $completa ? 'bg-gray-900' : 'bg-gray-200';
                                    @endphp

                                    <li class="flex-1">
                                        <div class="flex items-center">
                                            <div class="h-3 w-3 rounded-full {{ $dot }}"></div>

                                            @if (!$loop->last)
                                                <div class="mx-2 h-0.5 flex-1 {{ $line }}"></div>
                                            @endif
                                        </div>

                                        <div class="mt-2 text-xs font-medium {{ $txt }}">
                                            {{ $etapa }}
                                            @if ($actual)
                                                <span class="text-gray-500 font-normal"> (Actual)</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>

                        <p class="mt-3 text-xs text-gray-500">
                            Las etapas pueden avanzar según revisión de coordinación y aprobación de gerencia.
                        </p>
                    </div>

                    {{-- Datos del estudiante --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Datos del estudiante</div>

                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-500">Nombre</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->estudiante_nombre }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Email</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->estudiante_email }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Puntaje Saber</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->puntaje_saber }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Promedio universitario</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->promedio_universitario }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Perfil descriptivo --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Perfil descriptivo (coordinación)</div>
                        <div class="mt-2 text-sm text-gray-800 whitespace-pre-line">
                            {{ $postulacion->perfil_descriptivo ?? 'Aún no hay perfil descriptivo registrado.' }}
                        </div>
                    </div>

                    {{-- Documentos (con links) --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Documentos</div>

                        <div class="mt-3 space-y-3 text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="font-medium text-gray-900">PDF Notas</div>
                                    <div class="text-gray-500">
                                        {{ $postulacion->pdf_notas ? basename($postulacion->pdf_notas) : 'No adjuntado' }}
                                    </div>
                                </div>

                                @if ($postulacion->pdf_notas)
                                    <a class="text-indigo-600 hover:text-indigo-900"
                                       href="{{ asset('storage/' . $postulacion->pdf_notas) }}"
                                       target="_blank" rel="noopener">
                                        Abrir
                                    </a>
                                @endif
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="font-medium text-gray-900">PDF Matrícula</div>
                                    <div class="text-gray-500">
                                        {{ $postulacion->pdf_matricula ? basename($postulacion->pdf_matricula) : 'No adjuntado' }}
                                    </div>
                                </div>

                                @if ($postulacion->pdf_matricula)
                                    <a class="text-indigo-600 hover:text-indigo-900"
                                       href="{{ asset('storage/' . $postulacion->pdf_matricula) }}"
                                       target="_blank" rel="noopener">
                                        Abrir
                                    </a>
                                @endif
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-gray-500">
                            Si los enlaces no abren, asegúrate de haber ejecutado: <code>php artisan storage:link</code>
                        </p>
                    </div>

                </div>
            </div>

            {{-- Historial real (si ya creaste la tabla postulacion_estado_historias y la relación) --}}
            @if (method_exists($postulacion, 'historicoEstados') && $postulacion->relationLoaded('historicoEstados'))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Historial de cambios</div>

                        @if ($postulacion->historicoEstados->isEmpty())
                            <div class="mt-3 text-sm text-gray-600">No hay historial registrado.</div>
                        @else
                            <ol class="mt-4 space-y-4">
                                @foreach ($postulacion->historicoEstados as $h)
                                    <li class="flex gap-3">
                                        <div class="mt-1 h-2 w-2 rounded-full bg-gray-900"></div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $h->estado_nuevo }}
                                                @if ($h->estado_anterior)
                                                    <span class="text-gray-500 font-normal"> (antes: {{ $h->estado_anterior }})</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($h->cambiado_en)->format('Y-m-d H:i') }}
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
