<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mis postulaciones
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Aquí puedes ver el estado de tus postulaciones y gestionar tus documentos.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('student.postulaciones.create') }}"
                   class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                    Nueva postulación
                </a>

                <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    Volver al inicio
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($postulaciones->isEmpty())
                        <div class="rounded-md border border-gray-200 p-6 text-gray-700">
                            Aún no tienes postulaciones registradas.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
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

                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                #{{ $postulacion->id }}
                                            </td>

                                            <td class="px-4 py-3 text-sm">
                                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $tipoBadge }}">
                                                    {{ $tipoLabel }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-sm">
                                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $estadoBadge }}">
                                                    {{ $estado }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ optional($postulacion->updated_at)->format('Y-m-d H:i') }}
                                            </td>

                                            <td class="px-4 py-3 text-sm text-right space-x-3">
                                                <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    Ver
                                                </a>

                                                @if ($estado === 'Pendiente')
                                                    <a href="{{ route('student.postulaciones.edit', $postulacion) }}"
                                                       class="text-gray-700 hover:text-gray-900">
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
</x-app-layout>
