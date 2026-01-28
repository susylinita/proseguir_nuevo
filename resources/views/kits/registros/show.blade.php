<x-app-kits-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registro de Kit – {{ $registro->nino_nombre }}
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('kits.registros.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    Volver a mis registros
                </a>

                @if (!in_array($registro->estado, ['Aprobado','Rechazado','Entregado']))
                    <a href="{{ route('kits.registros.edit', $registro) }}"
                       class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                        Editar
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-5">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Estado</div>
                            <div class="mt-1 text-sm font-medium text-gray-900">{{ $registro->estado }}</div>
                        </div>

                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500">Última actualización</div>
                            <div class="mt-1 text-sm font-medium text-gray-900">
                                {{ optional($registro->updated_at)->format('Y-m-d H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Datos del niño</div>

                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-500">Nombre</div>
                                <div class="font-medium text-gray-900">{{ $registro->nino_nombre }}</div>
                            </div>

                            <div>
                                <div class="text-gray-500">Documento</div>
                                <div class="font-medium text-gray-900">{{ $registro->nino_documento ?? 'N/D' }}</div>
                            </div>

                            <div>
                                <div class="text-gray-500">Fecha nacimiento</div>
                                <div class="font-medium text-gray-900">
                                    {{ $registro->nino_fecha_nacimiento?->format('Y-m-d') ?? 'N/D' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Institución / Grado</div>
                                <div class="font-medium text-gray-900">
                                    {{ $registro->institucion ?? 'N/D' }}{{ $registro->grado ? ' – '.$registro->grado : '' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Observaciones</div>
                        <div class="mt-2 text-sm text-gray-800 whitespace-pre-line">
                            {{ $registro->observaciones ?? 'Sin observaciones.' }}
                        </div>
                    </div>

                    <div class="rounded-md border border-gray-200 p-4">
                        <div class="text-xs uppercase tracking-wider text-gray-500">Documentos</div>

                        <div class="mt-3 space-y-3 text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="font-medium text-gray-900">Documento del niño</div>
                                    <div class="text-gray-500">
                                        {{ $registro->pdf_documento ? basename($registro->pdf_documento) : 'No adjuntado' }}
                                    </div>
                                </div>

                                @if ($registro->pdf_documento)
                                    <a href="{{ route('kits.archivos.documento', $registro) }}"
                                    target="_blank"
                                    class="text-indigo-600 hover:text-indigo-900">
                                        Ver / Descargar
                                    </a>
                                @endif
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="font-medium text-gray-900">Certificado / soporte</div>
                                    <div class="text-gray-500">
                                        {{ $registro->pdf_certificado ? basename($registro->pdf_certificado) : 'No adjuntado' }}
                                    </div>
                                </div>

                                @if ($registro->pdf_certificado)
                                    <a href="{{ route('kits.archivos.certificado', $registro) }}"
                                    target="_blank">
                                        Ver / Descargar
                                    </a>
                                @endif
                            </div>
                        </div>

                        <p class="mt-4 text-xs text-gray-500">
                            * Si los enlaces no abren, asegúrate de haber ejecutado: <code>php artisan storage:link</code>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
