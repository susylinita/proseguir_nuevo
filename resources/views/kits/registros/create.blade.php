<x-app-kits-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar niño – Kits Escolares
            </h2>

            <a href="{{ route('kits.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                Volver al dashboard
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

                    <form method="POST"
                          action="{{ route('kits.registros.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Nombre completo del niño
                                </label>
                                <input name="nino_nombre" type="text"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('nino_nombre') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Documento (opcional)
                                </label>
                                <input name="nino_documento" type="text"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('nino_documento') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Fecha de nacimiento (opcional)
                                </label>
                                <input name="nino_fecha_nacimiento" type="date"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('nino_fecha_nacimiento') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Institución (opcional)
                                </label>
                                <input name="institucion" type="text"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('institucion') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Grado (opcional)
                                </label>
                                <input name="grado" type="text"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('grado') }}">
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Documento del niño (PDF opcional)
                                </label>
                                <input name="pdf_documento" type="file" accept=".pdf,application/pdf"
                                       class="mt-1 block w-full text-sm text-gray-700">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Certificado / soporte (PDF opcional)
                                </label>
                                <input name="pdf_certificado" type="file" accept=".pdf,application/pdf"
                                       class="mt-1 block w-full text-sm text-gray-700">
                            </div>

                            <p class="text-xs text-gray-500">
                                * Si los archivos no abren luego, asegúrate de tener <code>php artisan storage:link</code>.
                            </p>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('kits.dashboard') }}"
                               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                                Guardar registro
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
