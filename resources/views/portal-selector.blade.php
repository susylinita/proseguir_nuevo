<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Selecciona tu portal
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">

                <p class="text-gray-700 mb-6">
                    Hola <strong>{{ auth()->user()->name }}</strong>,  
                    selecciona el portal al que deseas ingresar:
                </p>

                <form method="POST" action="{{ route('portal.selector.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Portal Estudiante --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="portal" value="estudiante" class="peer hidden" required>
                            <div class="h-full rounded-xl border p-6 peer-checked:border-blue-600 peer-checked:ring-2 peer-checked:ring-blue-500">
                                <h3 class="font-semibold text-lg">Postulaciones / Becas</h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Postulación universitaria, inicio de carrera o renovación de beca.
                                </p>
                            </div>
                        </label>

                        {{-- Portal Kits --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="portal" value="kits" class="peer hidden">
                            <div class="h-full rounded-xl border p-6 peer-checked:border-emerald-600 peer-checked:ring-2 peer-checked:ring-emerald-500">
                                <h3 class="font-semibold text-lg">Kits Escolares</h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Registro de niños y cargue de documentos para kits escolares.
                                </p>
                            </div>
                        </label>

                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                                class="rounded-md bg-gray-900 px-6 py-2.5 text-sm font-semibold text-white hover:bg-gray-700">
                            Continuar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
