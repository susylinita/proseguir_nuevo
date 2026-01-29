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
                <a href="{{ route('student.dashboard') }}"
                class="text-sm text-gray-600 hover:text-gray-900">
                    Volver al dashboard
                </a>

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
        if ($estado === 'Entrevista') $badge = 'bg-blue-100 text-blue-800';
        if ($estado === 'Aprobado') $badge = 'bg-green-100 text-green-800';
        if ($estado === 'Rechazado') $badge = 'bg-red-100 text-red-800';

        $tipo = $postulacion->tipo_postulacion ?? 'primer_semestre';
        $tipoLabel = match ($tipo) {
            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
            'otro_semestre' => 'Ingreso a otro semestre (primera vez)',
            'renovacion' => 'Renovación (ya becado)',
            default => 'N/D',
        };

        // Pendientes (según tipo)
        $pendientes = [];

        if ($tipo === 'renovacion') {
            if (empty($postulacion->anexo_certificado_notas)) $pendientes[] = 'Certificado de notas';
            if (empty($postulacion->anexo_recibo_matricula)) $pendientes[] = 'Recibo de matrícula';
        } else {
            if (empty($postulacion->anexo_doc_identidad)) $pendientes[] = 'Documento de identidad';
            if (empty($postulacion->anexo_foto_documento)) $pendientes[] = 'Foto tipo documento';
            if (empty($postulacion->anexo_certificado_bancario)) $pendientes[] = 'Certificado cuenta bancaria';
            if (is_null($postulacion->promedio_carrera)) $pendientes[] = 'Promedio de carrera';
        }

        // Etapas para timeline visual
        $etapas = ['Pendiente', 'Entrevista', 'Aprobado'];
        $rechazada = ($estado === 'Rechazado');

        $indiceEstado = array_search($estado, $etapas, true);
        $indiceEstado = ($indiceEstado === false) ? -1 : $indiceEstado;

        $generoLabel = $postulacion->genero ?: 'N/D';

        // Helper para links "ver" (inline)
        $fileUrl = fn(string $field) => route('student.postulaciones.file', [$postulacion, $field]);
    @endphp

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Estado</div>
                            <div class="mt-2">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badge }}">
                                    {{ $estado }}
                                </span>
                            </div>
                        </div>

                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Tipo</div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ $tipoLabel }}
                            </div>
                        </div>

                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Última actualización</div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ optional($postulacion->updated_at)->format('Y-m-d H:i') }}
                            </div>
                        </div>

                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Pendientes</div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ count($pendientes) }}
                            </div>
                        </div>
                    </div>

                    {{-- Pendientes --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Pendientes o incompletos</div>

                        @if (count($pendientes) === 0)
                            <div class="mt-2 text-sm text-green-700">
                                ¡Todo completo! No tienes pendientes.
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
                                        Completar información
                                    </a>
                                </div>
                            @else
                                <div class="mt-3 text-sm text-gray-600">
                                    Tu postulación ya no está en Pendiente. Si necesitas actualizar, contacta a coordinación.
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Timeline --}}
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

                    {{-- Datos del estudiante + foto --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-4">
                            Datos del estudiante
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <div class="text-gray-500">Nombre</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->estudiante_nombre }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Email</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->estudiante_email }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Fecha de nacimiento</div>
                                        <div class="font-medium text-gray-900">
                                            {{ $postulacion->fecha_nacimiento ? $postulacion->fecha_nacimiento->format('Y-m-d') : 'N/D' }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Documento de identidad</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->documento_identidad ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Teléfono celular</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->telefono_celular ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Teléfono fijo</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->telefono_fijo ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Dirección</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->direccion ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Barrio</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->barrio ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Género</div>
                                        <div class="font-medium text-gray-900">{{ $generoLabel }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-center md:justify-end">
                                @if (!empty($postulacion->anexo_foto_documento))
                                    <div class="text-center">
                                        <img
                                            src="{{ $fileUrl('anexo_foto_documento') }}"
                                            alt="Foto tipo documento"
                                            class="w-36 sm:w-60 h-auto rounded-md border border-gray-300 shadow-sm object-cover"
                                        >
                                    </div>
                                @else
                                    <div class="w-36 sm:w-44 h-44 flex items-center justify-center rounded-md border border-dashed border-gray-300 text-xs text-gray-400 text-center px-2">
                                        Sin foto tipo documento
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- Acudiente --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Datos del acudiente</div>

                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-500">Nombre</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->nombre_acudiente ?: 'N/D' }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Teléfono</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->telefono_acudiente ?: 'N/D' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Estudios --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Estudios</div>

                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            @if ($tipo === 'primer_semestre')
                                <div>
                                    <div class="text-gray-500">Universidad a la que aplica</div>
                                    <div class="font-medium text-gray-900">{{ $postulacion->universidad_aplica ?: 'N/D' }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-500">Carrera (pregrado)</div>
                                    <div class="font-medium text-gray-900">{{ $postulacion->carrera_aplica ?: 'N/D' }}</div>
                                </div>
                            @elseif ($tipo === 'otro_semestre')
                                <div>
                                    <div class="text-gray-500">Universidad (actual)</div>
                                    <div class="font-medium text-gray-900">{{ $postulacion->universidad_actual ?: 'N/D' }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-500">Carrera (pregrado)</div>
                                    <div class="font-medium text-gray-900">{{ $postulacion->carrera_actual ?: 'N/D' }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-500">Semestre en curso</div>
                                    <div class="font-medium text-gray-900">{{ $postulacion->semestre_en_curso ?: 'N/D' }}</div>
                                </div>
                                
                            @else
                                <div class="sm:col-span-2 text-sm text-gray-700">
                                    Renovación: solo se validan documentos de notas y matrícula (y cuenta bancaria si cambió).
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Datos bancarios --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Datos bancarios</div>

                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-500">Banco</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->banco ?: 'N/D' }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Titular</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->titular_cuenta ?: 'N/D' }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Tipo de cuenta</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->tipo_cuenta ?: 'N/D' }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500">Número de cuenta</div>
                                <div class="font-medium text-gray-900">{{ $postulacion->numero_cuenta ?: 'N/D' }}</div>
                            </div>

                            @if ($tipo === 'renovacion')
                                <div class="sm:col-span-2">
                                    <div class="text-gray-500">Cuenta actualizada</div>
                                    <div class="font-medium text-gray-900">
                                        {{ $postulacion->cuenta_actualizada ? 'Sí' : 'No' }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Información adicional</div>
                        <div class="mt-2 text-sm text-gray-800 whitespace-pre-line">
                            {{ $postulacion->como_encontro ?: 'Sin respuesta.' }}
                        </div>
                    </div>

                    {{-- Perfil descriptivo --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Perfil descriptivo (coordinación)</div>
                        <div class="mt-2 text-sm text-gray-800 whitespace-pre-line">
                            {{ $postulacion->perfil_descriptivo ?? 'Aún no hay perfil descriptivo registrado.' }}
                        </div>
                    </div>

                    {{-- Documentos (INLINE, no descarga) --}}
                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                            Documentos
                        </div>

                        <div class="space-y-4 text-sm">

                            @php
                                $docs = [
                                    ['label' => 'Documento de identidad', 'field' => 'anexo_doc_identidad'],
                                    ['label' => 'Certificado bancario', 'field' => 'anexo_certificado_bancario'],
                                    ['label' => 'Notas académicas', 'field' => 'pdf_notas'],
                                    ['label' => 'Recibo de matrícula', 'field' => 'pdf_matricula'],
                                ];

                                if ($tipo === 'renovacion') {
                                    $docs[] = ['label' => 'Certificado de notas (renovación)', 'field' => 'anexo_certificado_notas'];
                                    $docs[] = ['label' => 'Recibo matrícula (renovación)', 'field' => 'anexo_recibo_matricula'];
                                }
                            @endphp

                            @foreach ($docs as $d)
                                @php
                                    $path = $postulacion->{$d['field']} ?? null;
                                @endphp

                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $d['label'] }}</div>
                                        <div class="text-gray-500">
                                            {{ $path ? basename($path) : 'No adjuntado' }}
                                        </div>
                                    </div>

                                    @if ($path)
                                        <a href="{{ $fileUrl($d['field']) }}"
                                           target="_blank"
                                           rel="noopener"
                                           class="text-indigo-600 hover:text-indigo-900">
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
