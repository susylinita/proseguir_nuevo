<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear postulación
            </h2>

            <a href="{{ route('student.postulaciones.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                Volver a mis postulaciones
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="text-sm font-semibold text-red-800">Revisa los campos:</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Bloque informativo (solo lectura) --}}
                    <div class="rounded-md border border-gray-200 bg-gray-50 p-4 text-sm">
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-2">
                            Datos del postulante
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-gray-500">Nombre</div>
                                <div class="font-medium text-gray-900">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Correo electrónico</div>
                                <div class="font-medium text-gray-900">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 text-xs text-gray-500">
                            Estos datos se toman automáticamente de tu cuenta y no se pueden modificar desde la postulación.
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('student.postulaciones.store') }}"
                          enctype="multipart/form-data"
                          class="mt-6">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Puntaje Saber (mín. 300)
                                </label>
                                <input name="puntaje_saber" type="number" step="0.01"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ old('puntaje_saber') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Promedio universitario (mín. 3.8)
                                </label>
                                <input name="promedio_universitario" type="number" step="0.01"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ old('promedio_universitario') }}" required>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    PDF Notas (opcional)
                                </label>
                                <input name="pdf_notas" type="file" accept=".pdf,application/pdf"
                                       class="mt-1 block w-full text-sm text-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    PDF Matrícula (opcional)
                                </label>
                                <input name="pdf_matricula" type="file" accept=".pdf,application/pdf"
                                       class="mt-1 block w-full text-sm text-gray-700">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('student.postulaciones.index') }}"
                               class="rounded-md border px-4 py-2 text-sm">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="rounded-md bg-gray-900 px-4 py-2 text-sm text-white">
                                Crear postulación
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
