<x-app-layout>
    <x-slot name="header">
        <div class="rounded-2xl p-8 
                    bg-gradient-to-r from-slate-100 via-slate-200 to-emerald-100 
                    border border-slate-200 shadow-sm">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                {{-- Lado izquierdo --}}
                <div>
                    <div class="inline-flex items-center gap-2 
                                px-4 py-1.5 rounded-full 
                                bg-white/70 backdrop-blur 
                                border border-slate-300 
                                text-xs font-medium text-slate-700 shadow-sm">
                        📄 Postulación
                    </div>

                    <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-slate-900">
                        Detalle de postulación 
                        <span class="text-slate-600">#{{ $postulacion->id }}</span>
                    </h1>

                    <p class="mt-3 text-slate-700 max-w-2xl leading-relaxed">
                        Revisa el estado actual, los documentos cargados y el historial
                        de movimientos de tu postulación.
                    </p>

                    <p class="mt-3 text-sm text-slate-500">
                        Última actualización:
                        {{ optional($postulacion->updated_at)->timezone('America/Bogota')->format('Y-m-d H:i') }}
                    </p>
                </div>

                {{-- Botones derecha --}}
                <div class="flex flex-wrap items-center gap-4">

                    <a href="{{ route('student.postulaciones.index') }}"
                       class="inline-flex items-center gap-2 
                              bg-blue-600 text-white 
                              px-6 py-3 rounded-xl 
                              font-semibold shadow-md 
                              hover:bg-blue-700 transition">
                        Ver mis postulaciones
                    </a>

                    <a href="{{ route('student.dashboard') }}"
                       class="inline-flex items-center gap-2 
                              bg-white border border-slate-300 
                              text-slate-700 px-6 py-3 
                              rounded-xl font-medium 
                              hover:bg-slate-50 transition">
                        Volver al dashboard
                    </a>

                    @if (($postulacion->estado ?? '') === 'Postulado')
                        <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                           class="inline-flex items-center gap-2 
                                  bg-slate-900 text-white 
                                  px-6 py-3 rounded-xl 
                                  font-semibold shadow-md 
                                  hover:bg-slate-800 transition">
                            Editar
                        </a>
                    @endif

                </div>

            </div>
        </div>
    </x-slot>

    @php
        $estado = $postulacion->estado ?? 'Postulado';

        $badge = match ($estado) {
            'Postulado' => 'bg-slate-100 text-slate-800',
            'En estudio' => 'bg-blue-100 text-blue-800',
            'Aprobado' => 'bg-green-100 text-green-800',
            'Rechazado' => 'bg-red-100 text-red-800',
            'Cancelado' => 'bg-gray-100 text-gray-700',
            default => 'bg-gray-100 text-gray-800',
        };

        $tipo = $postulacion->tipo_postulacion ?? 'primer_semestre';

        $tipoLabel = match ($tipo) {
            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
            'otro_semestre' => 'Ingreso a otro semestre (primera vez)',
            'renovacion' => 'Renovación (ya becado)',
            default => 'N/D',
        };

        // Pendientes según tipo de postulación
        $pendientes = [];

        if ($tipo === 'renovacion') {
            if (empty($postulacion->anexo_certificado_notas)) {
                $pendientes[] = 'Certificado de notas';
            }

            if (empty($postulacion->anexo_recibo_matricula)) {
                $pendientes[] = 'Recibo de matrícula';
            }

            if (($postulacion->cuenta_actualizada ?? false) && empty($postulacion->anexo_certificado_bancario)) {
                $pendientes[] = 'Certificado cuenta bancaria';
            }
        } else {
            if (empty($postulacion->anexo_doc_identidad)) {
                $pendientes[] = 'Documento de identidad';
            }

            if (empty($postulacion->anexo_foto_documento)) {
                $pendientes[] = 'Foto tipo documento';
            }

            if (empty($postulacion->anexo_certificado_bancario)) {
                $pendientes[] = 'Certificado cuenta bancaria';
            }

            if (is_null($postulacion->promedio_carrera)) {
                $pendientes[] = 'Promedio de carrera';
            }
        }

        // Timeline visual con nuevos estados
        if ($estado === 'Rechazado') {
            $etapas = ['Postulado', 'En estudio', 'Rechazado'];
        } elseif ($estado === 'Cancelado') {
            $etapas = ['Postulado', 'Cancelado'];
        } else {
            $etapas = ['Postulado', 'En estudio', 'Aprobado'];
        }

        $indiceEstado = array_search($estado, $etapas, true);
        $indiceEstado = ($indiceEstado === false) ? 0 : $indiceEstado;

        $generoLabel = $postulacion->genero ?: 'N/D';

        // Helper para links "ver" documentos
        $fileUrl = fn(string $field) => route('student.postulaciones.file', [$postulacion, $field]);
    @endphp

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-6 space-y-8">

            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
                <div class="p-10 space-y-8">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                            <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                                Estado
                            </div>
                            <div class="mt-2">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                                    {{ $estado }}
                                </span>
                            </div>
                        </div>

                        <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                            <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                                Tipo
                            </div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ $tipoLabel }}
                            </div>
                        </div>

                        <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                            <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                                Última actualización
                            </div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ optional($postulacion->updated_at)->timezone('America/Bogota')->format('Y-m-d H:i') }}
                            </div>
                        </div>

                        <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                            <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                                Pendientes
                            </div>
                            <div class="mt-2 text-sm font-medium text-gray-900">
                                {{ count($pendientes) }}
                            </div>
                        </div>
                    </div>

                    {{-- Pendientes --}}
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Pendientes o incompletos
                        </div>

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

                            @if (($postulacion->estado ?? '') === 'Postulado')
                                <div class="mt-3">
                                    <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                                       class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                                        Completar información
                                    </a>
                                </div>
                            @else
                                <div class="mt-3 text-sm text-gray-600">
                                    Esta solicitud ya inició revisión por parte de la Fundación. Si necesitas actualizar información o documentos, contacta a coordinación.
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Timeline --}}
                    <div class="border border-slate-200 rounded-2xl p-8 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Estado del proceso
                        </div>

                        @if ($estado === 'Rechazado')
                            <div class="mt-4 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                                Tu postulación fue rechazada. Si necesitas aclaraciones, revisa el perfil descriptivo o contacta a la Fundación.
                            </div>
                        @endif

                        @if ($estado === 'Cancelado')
                            <div class="mt-4 rounded-lg bg-slate-50 border border-slate-200 p-4 text-sm text-slate-700">
                                Tu postulación fue cancelada y no continuará el proceso.
                            </div>
                        @endif

                        <div class="mt-8">
                            <ol class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">

                                @foreach ($etapas as $i => $etapa)
                                    @php
                                        $completa = ($indiceEstado >= $i);
                                        $actual = ($estado === $etapa);

                                        $circle = match ($etapa) {
                                            'Aprobado' => $completa ? 'bg-green-600 text-white' : 'bg-slate-200 text-slate-500',
                                            'Rechazado' => $completa ? 'bg-red-600 text-white' : 'bg-slate-200 text-slate-500',
                                            'Cancelado' => $completa ? 'bg-gray-600 text-white' : 'bg-slate-200 text-slate-500',
                                            default => $completa ? 'bg-slate-900 text-white' : 'bg-slate-200 text-slate-500',
                                        };

                                        $line = $completa ? 'bg-slate-900' : 'bg-slate-200';
                                    @endphp

                                    <li class="flex-1 relative">

                                        <div class="flex md:flex-col items-center md:items-center gap-4">

                                            <div class="relative z-10 flex items-center justify-center h-10 w-10 rounded-full text-sm font-semibold shadow {{ $circle }}">
                                                {{ $i + 1 }}
                                            </div>

                                            @if (!$loop->last)
                                                <div class="hidden md:block absolute top-5 left-1/2 w-full h-0.5 {{ $line }}"></div>
                                            @endif

                                            <div class="text-sm font-medium {{ $completa ? 'text-slate-900' : 'text-slate-400' }}">
                                                {{ $etapa }}

                                                @if ($actual)
                                                    <span class="block text-xs text-slate-500 mt-1">
                                                        Etapa actual
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                    </li>
                                @endforeach

                            </ol>
                        </div>

                        <p class="mt-8 text-xs text-slate-500">
                            Las etapas pueden avanzar según revisión de coordinación y decisión de gerencia.
                        </p>
                    </div>

                    {{-- Datos del estudiante + foto --}}
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
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
                                        <div class="font-medium text-gray-900">{{ $postulacion->estudiante_email ?: 'N/D' }}</div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Fecha de nacimiento</div>
                                        <div class="font-medium text-gray-900">
                                            {{ $postulacion->fecha_nacimiento ? \Carbon\Carbon::parse($postulacion->fecha_nacimiento)->format('d/m/Y') : 'N/D' }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">Tipo de documento</div>
                                        <div class="font-medium text-gray-900">{{ $postulacion->tipo_documento ?: 'N/D' }}</div>
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
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Datos del acudiente
                        </div>

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
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Estudios
                        </div>

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
                                    Renovación: se validan documentos de notas, matrícula y certificado bancario si actualizó su cuenta.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Datos bancarios --}}
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Datos bancarios
                        </div>

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
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Información adicional
                        </div>
                        <div class="mt-2 text-sm text-gray-800 whitespace-pre-line">
                            {{ $postulacion->como_encontro ?: 'Sin respuesta.' }}
                        </div>
                    </div>

                    {{-- Perfil descriptivo --}}
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Perfil descriptivo (coordinación)
                        </div>
                        <div class="mt-2 text-sm text-gray-800 whitespace-pre-line">
                            {{ $postulacion->perfil_descriptivo ?? 'Aún no hay perfil descriptivo registrado.' }}
                        </div>
                    </div>

                    {{-- Documentos --}}
                    <div class="border border-slate-200 rounded-xl p-6 bg-white shadow-sm">
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                            Documentos
                        </div>

                        <div class="space-y-4 text-sm">

                            @php
                                $docs = [];

                                if ($tipo !== 'renovacion') {
                                    $docs[] = ['label' => 'Documento de identidad', 'field' => 'anexo_doc_identidad'];
                                    $docs[] = ['label' => 'Foto tipo documento', 'field' => 'anexo_foto_documento'];
                                    $docs[] = ['label' => 'Certificado bancario', 'field' => 'anexo_certificado_bancario'];
                                    $docs[] = ['label' => 'Notas académicas', 'field' => 'pdf_notas'];
                                    $docs[] = ['label' => 'Recibo de matrícula', 'field' => 'pdf_matricula'];
                                } else {
                                    $docs[] = ['label' => 'Certificado de notas', 'field' => 'anexo_certificado_notas'];
                                    $docs[] = ['label' => 'Recibo matrícula', 'field' => 'anexo_recibo_matricula'];

                                    if ($postulacion->cuenta_actualizada) {
                                        $docs[] = ['label' => 'Certificado bancario', 'field' => 'anexo_certificado_bancario'];
                                    }
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
                        <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
                            Historial de cambios
                        </div>

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