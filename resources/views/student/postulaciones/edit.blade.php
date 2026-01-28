<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar postulación #{{ $postulacion->id }}
            </h2>

            <a href="{{ route('student.postulaciones.show', $postulacion) }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                Cancelar
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

                    <div class="mb-4 rounded-md bg-gray-50 p-4 text-sm text-gray-700">
                        Puedes actualizar tu información y adjuntar documentos mientras tu postulación esté en
                        <strong>Pendiente</strong> (o cuando la coordinadora te la devuelva, si aplicas esa regla).
                    </div>

                    {{-- Datos del postulante (solo lectura) --}}
                    <div class="mb-6 rounded-md border border-gray-200 bg-gray-50 p-4 text-sm">
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
                          action="{{ route('student.postulaciones.update', $postulacion) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="puntaje_saber">
                                    Puntaje Saber (mín. 300)
                                </label>
                                <input id="puntaje_saber" name="puntaje_saber" type="number" step="0.01" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('puntaje_saber', $postulacion->puntaje_saber) }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="promedio_universitario">
                                    Promedio universitario (mín. 3.8)
                                </label>
                                <input id="promedio_universitario" name="promedio_universitario" type="number" step="0.01" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('promedio_universitario', $postulacion->promedio_universitario) }}" required>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="pdf_notas">
                                    PDF Notas (opcional)
                                </label>
                                <input id="pdf_notas" name="pdf_notas" type="file" accept=".pdf,application/pdf"
                                       class="mt-1 block w-full text-sm text-gray-700">
                                @if ($postulacion->pdf_notas)
                                    <p class="mt-1 text-xs text-gray-500">
                                        Ya hay un archivo cargado: <span class="font-medium">{{ basename($postulacion->pdf_notas) }}</span>
                                    </p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="pdf_matricula">
                                    PDF Matrícula (opcional)
                                </label>
                                <input id="pdf_matricula" name="pdf_matricula" type="file" accept=".pdf,application/pdf"
                                       class="mt-1 block w-full text-sm text-gray-700">
                                @if ($postulacion->pdf_matricula)
                                    <p class="mt-1 text-xs text-gray-500">
                                        Ya hay un archivo cargado: <span class="font-medium">{{ basename($postulacion->pdf_matricula) }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                                Guardar cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
