<x-filament-panels::page>
    <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="rounded-3xl border border-slate-200 bg-white/90 backdrop-blur shadow-xl">
                <div class="p-6 sm:p-7">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-slate-900">
                            Acceso administrativo
                        </h2>
                        <p class="mt-1 text-sm text-slate-600">
                            Inicia sesión para gestionar postulaciones, kits, aprobaciones y reportes.
                        </p>
                    </div>

                    <form wire:submit="authenticate" class="space-y-4">
                        {{ $this->form }}

                        <button
                            type="submit"
                            class="w-full inline-flex justify-center items-center rounded-md bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700 transition"
                        >
                            Ingresar
                        </button>

                        <div class="pt-2 text-center text-sm text-slate-600">
                            ¿Eres postulante o acudiente?
                            <a href="{{ url('/') }}" class="font-semibold text-blue-800 hover:text-blue-900">
                                Ingresa desde el portal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center text-xs text-slate-500">
                © {{ date('Y') }} Fundación Proseguir
            </div>
        </div>
    </div>
</x-filament-panels::page>
