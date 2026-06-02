<x-app-layout>

    @if ($errors->has('general'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
        <strong>Solicitud bloqueada.</strong>
        <p class="mt-1">{{ $errors->first('general') }}</p>
        <p class="mt-1">Por favor, contacta al administrador.</p>
    </div>
    @endif

    <x-slot name="header">
    <div class="rounded-2xl p-8 
                bg-gradient-to-r from-slate-100 via-slate-200 to-blue-100 
                border border-slate-200 shadow-sm">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

            {{-- Lado izquierdo --}}
            <div>

                <div class="inline-flex items-center gap-2 
                            px-4 py-1.5 rounded-full 
                            bg-white/70 backdrop-blur 
                            border border-slate-300 
                            text-xs font-medium text-slate-700 shadow-sm">
                    📄 Gestión de solicitudes
                </div>

                <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-slate-900">
                    Mis postulaciones
                </h1>

                <p class="mt-3 text-slate-700 max-w-2xl leading-relaxed">
                    Consulta el estado de tus solicitudes, revisa avances y administra tus documentos adjuntos.
                </p>

              

            </div>

            {{-- Botones derecha --}}
            <div class="flex flex-wrap items-center gap-4">

                <a href="{{ route('student.postulaciones.create') }}"
                   class="inline-flex items-center gap-2 
                          bg-slate-900 text-white 
                          px-6 py-3 rounded-xl 
                          font-medium shadow-sm 
                          hover:bg-slate-800 transition">
                          @if (! auth()->user()?->becas_bloqueado)
                            + Nueva postulación
                            @endif
                </a>

                <a href="{{ route('student.dashboard') }}"
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


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-6 text-gray-900">

                    @if ($postulaciones->isEmpty())
                        <div class="rounded-md border border-gray-200 p-6 text-gray-700">
                            Aún no tienes postulaciones registradas.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actualizado</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($postulaciones as $postulacion)
                                        @php
                                            $estado = $postulacion->estado ?? 'N/D';

                                            $estadoBadge = match ($estado) {
                                                'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'Entrevista' => 'bg-blue-100 text-blue-800',
                                                'Aprobado' => 'bg-green-100 text-green-800',
                                                'Rechazado' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };

                                            $tipo = $postulacion->tipo_postulacion ?? 'primer_semestre';
                                            $tipoLabel = match ($tipo) {
                                                'primer_semestre' => 'Primer semestre',
                                                'otro_semestre' => 'Otro semestre',
                                                'renovacion' => 'Renovación',
                                                default => 'N/D',
                                            };

                                            $tipoBadge = match ($tipo) {
                                                'primer_semestre' => 'bg-purple-100 text-purple-800',
                                                'otro_semestre' => 'bg-indigo-100 text-indigo-800',
                                                'renovacion' => 'bg-teal-100 text-teal-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp

                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                #{{ $postulacion->id }}
                                            </td>

                                            <td class="px-4 py-3 text-sm">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $tipoBadge }}">

                                                    {{ $tipoLabel }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-sm">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $estadoBadge }}">
                                                    {{ $estado }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ optional($postulacion->updated_at)->format('Y-m-d H:i') }}
                                            </td>

                                            <td class="px-4 py-3 text-sm text-right">
                                                <div class="flex justify-end gap-2">

                                                    {{-- Botón Ver --}}
                                                    <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                                                    class="inline-flex items-center gap-1 
                                                            px-3 py-1.5 rounded-lg 
                                                            text-xs font-medium
                                                            bg-slate-100 text-slate-700 
                                                            border border-slate-200
                                                            hover:bg-slate-200 transition">
                                                        👁 Ver
                                                    </a>

                                                    {{-- Botón Editar --}}
                                                    @if ($estado === 'Pendiente')
                                                        <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                                                        class="inline-flex items-center gap-1 
                                                                px-3 py-1.5 rounded-lg 
                                                                text-xs font-medium
                                                                bg-slate-900 text-white 
                                                                hover:bg-slate-800 transition">
                                                            ✏ Editar
                                                        </a>
                                                    @endif

                                                </div>
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
</x-app-layout>
