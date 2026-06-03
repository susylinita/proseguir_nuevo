@php
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;

    $tipoPostulacion = match ($postulacion->tipo_postulacion) {
        'primer_semestre' => 'Ingreso a primer semestre',
        'otro_semestre' => 'Ingreso a otro semestre',
        'renovacion' => 'Renovación',
        default => 'N/D',
    };

    $documentos = [
        [
            'label' => 'Foto tipo documento',
            'field' => 'anexo_foto_documento',
            'visible' => filled($postulacion->anexo_foto_documento),
        ],
        [
            'label' => 'Documento de identidad',
            'field' => 'anexo_doc_identidad',
            'visible' => filled($postulacion->anexo_doc_identidad),
        ],
        [
            'label' => 'Certificado bancario',
            'field' => 'anexo_certificado_bancario',
            'visible' => filled($postulacion->anexo_certificado_bancario),
        ],
        [
            'label' => 'Notas académicas',
            'field' => 'pdf_notas',
            'visible' => filled($postulacion->pdf_notas) && $postulacion->tipo_postulacion !== 'renovacion',
        ],
        [
            'label' => 'Recibo de matrícula',
            'field' => 'pdf_matricula',
            'visible' => filled($postulacion->pdf_matricula) && $postulacion->tipo_postulacion !== 'renovacion',
        ],
        [
            'label' => 'Certificado de notas renovación',
            'field' => 'anexo_certificado_notas',
            'visible' => filled($postulacion->anexo_certificado_notas) && $postulacion->tipo_postulacion === 'renovacion',
        ],
        [
            'label' => 'Recibo matrícula renovación',
            'field' => 'anexo_recibo_matricula',
            'visible' => filled($postulacion->anexo_recibo_matricula) && $postulacion->tipo_postulacion === 'renovacion',
        ],
    ];

    $documentosVisibles = collect($documentos)->filter(fn ($doc) => $doc['visible']);
@endphp

<div class="space-y-6">

    {{-- Alerta de prioridad --}}
    @if ($postulacion->estado === 'Entrevista' && $postulacion->entrevista_recomendado)
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="text-sm font-semibold text-red-700">
                Solicitud recomendada para revisión prioritaria
            </div>
            <p class="mt-1 text-sm text-red-600">
                Esta postulación fue marcada por coordinación como recomendada para revisión de gerencia.
            </p>
        </div>
    @endif

    {{-- FOTO SUPERIOR DEL POSTULADO / BECADO --}}
<div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex flex-col items-center gap-4 sm:flex-row sm:items-center">
        <div class="flex h-32 w-32 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
            @if (!empty($postulacion->anexo_foto_documento))
                <img
                    src="{{ Storage::disk('public')->url($postulacion->anexo_foto_documento) }}"
                    alt="Foto del postulado"
                    class="h-full w-full object-cover"
                >
            @else
                <div class="flex h-full w-full items-center justify-center text-center text-sm font-semibold text-slate-400">
                    Sin foto
                </div>
            @endif
        </div>

        <div class="text-center sm:text-left">
            <div class="text-sm font-semibold uppercase tracking-wide text-slate-500">
                Postulado / Becado
            </div>

            <div class="mt-1 text-2xl font-black text-slate-900">
                {{ $postulacion->estudiante_nombre ?? 'Nombre no registrado' }}
            </div>

            <div class="mt-1 text-sm text-slate-500">
                Documento:
                <span class="font-semibold text-slate-700">
                    {{ $postulacion->tipo_documento ?? 'N/D' }}
                    {{ $postulacion->documento_identidad ?? '' }}
                </span>
            </div>

            <div class="mt-3 inline-flex rounded-full border px-3 py-1 text-sm font-bold
                @if (($postulacion->estado ?? '') === 'Aprobado')
                    border-green-200 bg-green-50 text-green-700
                @elseif (($postulacion->estado ?? '') === 'Rechazado')
                    border-red-200 bg-red-50 text-red-700
                @elseif (($postulacion->estado ?? '') === 'En estudio')
                    border-blue-200 bg-blue-50 text-blue-700
                @elseif (($postulacion->estado ?? '') === 'Pendiente aprobación gerencia')
                    border-indigo-200 bg-indigo-50 text-indigo-700
                @else
                    border-slate-200 bg-slate-50 text-slate-700
                @endif
            ">
                {{ $postulacion->estado ?? 'Sin estado' }}
            </div>
        </div>
    </div>
</div>


    {{-- Resumen principal --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Información del solicitante
        </h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-slate-500">Nombre completo</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->estudiante_nombre ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Correo electrónico</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->estudiante_email ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Tipo de documento</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->tipo_documento ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Número de documento</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->documento_identidad ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Fecha de nacimiento</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->fecha_nacimiento ? Carbon::parse($postulacion->fecha_nacimiento)->format('d/m/Y') : 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Género</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->genero ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Teléfono celular</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->telefono_celular ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Teléfono fijo</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->telefono_fijo ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Dirección</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->direccion ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Barrio</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->barrio ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Tipo de postulación</div>
                <div class="font-medium text-slate-900">
                    {{ $tipoPostulacion }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Estado actual</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->estado ?? 'N/D' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Puntajes --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Evaluación académica
        </h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <div class="text-slate-500">Puntaje Saber 11</div>
                <div class="font-medium {{ ($postulacion->puntaje_saber ?? 0) >= 300 ? 'text-green-700' : 'text-red-700' }}">
                    {{ $postulacion->puntaje_saber ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Promedio acumulado</div>
                <div class="font-medium {{ ($postulacion->promedio_universitario ?? 0) >= 3.8 ? 'text-green-700' : 'text-red-700' }}">
                    {{ $postulacion->promedio_universitario ?? 'N/D' }}
                </div>
            </div>


        </div>
    </div>

    {{-- Información académica --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Información académica
        </h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            @if ($postulacion->tipo_postulacion === 'primer_semestre')
                <div>
                    @if (!empty($postulacion->semestres_promedios))
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h3 class="text-lg font-bold text-slate-900">
            Historial académico por semestre
        </h3>

        <p class="mt-1 text-sm text-slate-500">
            Promedios acumulados registrados para el becario.
        </p>

        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($postulacion->semestres_promedios as $item)
                @php
                    $promedio = isset($item['promedio_acumulado'])
                        ? (float) $item['promedio_acumulado']
                        : null;

                    $colorClase = $promedio !== null && $promedio <= 3.8
                        ? 'text-red-700 bg-red-50 border-red-200'
                        : 'text-green-700 bg-green-50 border-green-200';
                @endphp

                <div class="rounded-xl border p-4 {{ $colorClase }}">
                    <div class="text-sm font-semibold">
                        Semestre {{ $item['semestre'] ?? 'N/D' }}
                    </div>

                    <div class="mt-1 text-2xl font-black">
                        {{ $promedio !== null ? number_format($promedio, 2) : 'N/D' }}
                    </div>

                    <div class="mt-1 text-xs font-medium opacity-80">
                        Promedio acumulado
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
                    <div class="text-slate-500">Universidad a la que aplica</div>
                    <div class="font-medium text-slate-900">
                        {{ $postulacion->universidad_aplica ?? 'N/D' }}
                    </div>
                </div>

                <div>
                    <div class="text-slate-500">Carrera a la que aplica</div>
                    <div class="font-medium text-slate-900">
                        {{ $postulacion->carrera_aplica ?? 'N/D' }}
                    </div>
                </div>
            @elseif ($postulacion->tipo_postulacion === 'otro_semestre')
                <div>
                    <div class="text-slate-500">Universidad actual</div>
                    <div class="font-medium text-slate-900">
                        {{ $postulacion->universidad_actual ?? 'N/D' }}
                    </div>
                </div>

                <div>
                    <div class="text-slate-500">Carrera actual</div>
                    <div class="font-medium text-slate-900">
                        {{ $postulacion->carrera_actual ?? 'N/D' }}
                    </div>
                </div>

                <div>
                    <div class="text-slate-500">Semestre en curso</div>
                    <div class="font-medium text-slate-900">
                        {{ $postulacion->semestre_en_curso ?? 'N/D' }}
                    </div>
                </div>
            @elseif ($postulacion->tipo_postulacion === 'renovacion')
                <div class="md:col-span-2">
                    <div class="text-slate-500">Renovación</div>
                    <div class="font-medium text-slate-900">
                        La solicitud corresponde a una renovación de beca.
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Acudiente --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Información del acudiente
        </h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-slate-500">Nombre del acudiente</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->nombre_acudiente ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Teléfono del acudiente</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->telefono_acudiente ?? 'N/D' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Datos bancarios --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Datos bancarios
        </h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-slate-500">Banco</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->banco ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Titular de la cuenta</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->titular_cuenta ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Tipo de cuenta</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->tipo_cuenta ?? 'N/D' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Número de cuenta</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->numero_cuenta ?? 'N/D' }}
                </div>
            </div>

            @if ($postulacion->tipo_postulacion === 'renovacion')
                <div>
                    <div class="text-slate-500">¿Actualizó cuenta bancaria?</div>
                    <div class="font-medium text-slate-900">
                        {{ $postulacion->cuenta_actualizada ? 'Sí' : 'No' }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Información adicional --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Información adicional
        </h3>

        <div class="mt-4 text-sm">
            <div class="text-slate-500">
                {{ $postulacion->tipo_postulacion === 'renovacion' ? 'Recomendación para la fundación o sugerencia' : '¿Cómo encontró la Fundación?' }}
            </div>

            <div class="mt-2 rounded-lg border border-slate-200 bg-slate-50 p-3 text-slate-800 leading-relaxed">
                {{ $postulacion->como_encontro ?: 'Sin respuesta.' }}
            </div>
        </div>
    </div>

    {{-- Perfil descriptivo --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Perfil descriptivo
        </h3>

        <div class="mt-2 rounded-lg border border-slate-200 bg-slate-50 p-3 text-sm text-slate-800 leading-relaxed">
            {{ $postulacion->perfil_descriptivo ?: 'Aún no hay perfil descriptivo registrado.' }}
        </div>
    </div>

    {{-- Entrevista --}}
    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Entrevista y observaciones de coordinación
        </h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-slate-500">Recomendado para gerencia</div>
                <div class="font-medium {{ $postulacion->entrevista_recomendado ? 'text-red-700' : 'text-slate-900' }}">
                    {{ $postulacion->entrevista_recomendado ? 'Sí, revisión prioritaria' : 'No' }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Fecha de entrevista</div>
                <div class="font-medium text-slate-900">
                    {{ $postulacion->entrevista_registrada_en ? Carbon::parse($postulacion->entrevista_registrada_en)->format('d/m/Y H:i') : 'N/D' }}
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="text-slate-500">Observaciones de la entrevista</div>
                <div class="mt-2 rounded-lg border border-slate-200 bg-white p-3 text-slate-800 leading-relaxed">
                    {{ $postulacion->entrevista_observaciones ?: 'Aún no hay observaciones registradas.' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Observaciones de gerencia --}}
    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Observaciones de gerencia
        </h3>

        <div class="mt-2 rounded-lg border border-amber-200 bg-white p-3 text-sm text-slate-800 leading-relaxed">
            {{ $postulacion->gerencia_observaciones ?: 'Aún no hay observaciones registradas por gerencia.' }}
        </div>

        @if ($postulacion->gerencia_observaciones_en)
            <p class="mt-2 text-xs text-slate-500">
                Última actualización:
                {{ Carbon::parse($postulacion->gerencia_observaciones_en)->format('d/m/Y H:i') }}
            </p>
        @endif
    </div>

    {{-- Motivo rechazo --}}
    @if (in_array($postulacion->estado, ['Rechazado', 'Cancelado'], true))
    <div class="rounded-xl border border-red-200 bg-red-50 p-4">
        <h3 class="text-base font-semibold text-red-700">
            {{ $postulacion->estado === 'Cancelado' ? 'Motivo de cancelación' : 'Motivo de rechazo' }}
        </h3>

        <div class="mt-3 rounded-lg border border-red-200 bg-white p-3 text-sm text-red-700">
            {{ filled($postulacion->observaciones) ? $postulacion->observaciones : 'Sin motivo registrado.' }}
        </div>
    </div>
@endif

    {{-- Documentos --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <h3 class="text-base font-semibold text-slate-900">
            Anexos y documentos
        </h3>

        @if ($documentosVisibles->isEmpty())
            <p class="mt-3 text-sm text-slate-500">
                No hay documentos adjuntos para esta postulación.
            </p>
        @else
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach ($documentosVisibles as $doc)
                    @php
                        $path = $postulacion->{$doc['field']};
                        $url = Storage::disk('public')->url($path);
                    @endphp

                    <div class="flex items-center justify-between gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3">
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-slate-900">
                                {{ $doc['label'] }}
                            </div>

                            <div class="mt-1 truncate text-xs text-slate-500">
                                {{ basename($path) }}
                            </div>
                        </div>

                        <a
                            href="{{ $url }}"
                            target="_blank"
                            rel="noopener"
                            class="shrink-0 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700"
                        >
                            Abrir
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>