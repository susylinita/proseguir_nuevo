<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Selecciona tu portal
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

                <p class="text-gray-700">
                    Elige a qué portal deseas ingresar:
                </p>

                <form method="POST" action="{{ route('portal.selector.store') }}" class="space-y-3">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button type="submit" name="portal" value="postulantes"
                            class="w-full rounded-md bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-700">
                            Portal Postulantes
                        </button>

                        <button type="submit" name="portal" value="kits"
                            class="w-full rounded-md bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                            Portal Kits Escolares
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
