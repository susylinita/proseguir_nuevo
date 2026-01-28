<x-app-kits-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis registros de Kits
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('kits.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    Volver al dashboard
                </a>
                <a href="{{ route('kits.registros.create') }}"
                   class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                    + Registrar niño
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($registros->isEmpty())
                        <div class="rounded-md border border-gray-200 p-6 text-gray-700">
                            Aún no has registrado niños para kits escolares.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Niño</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actualizado</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($registros as $r)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                {{ $r->nino_nombre }}
                                                @if($r->grado || $r->institucion)
                                                    <div class="text-xs text-gray-500">
                                                        {{ $r->grado ? 'Grado: '.$r->grado : '' }}
                                                        {{ ($r->grado && $r->institucion) ? ' • ' : '' }}
                                                        {{ $r->institucion ? $r->institucion : '' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ $r->estado }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                {{ optional($r->updated_at)->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-right space-x-2">
                                                <a class="text-indigo-600 hover:text-indigo-900"
                                                   href="{{ route('kits.registros.show', $r) }}">
                                                    Ver
                                                </a>

                                                @if (!in_array($r->estado, ['Aprobado','Rechazado','Entregado']))
                                                    <span class="text-gray-300">|</span>
                                                    <a class="text-gray-700 hover:text-gray-900"
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
</x-app-layout>
