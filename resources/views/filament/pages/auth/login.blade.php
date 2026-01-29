<x-filament-panels::page.simple>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900">
            Acceso administrativo
        </h2>
        <p class="mt-1 text-sm text-slate-600">
            Inicia sesión para gestionar postulaciones, kits, aprobaciones y reportes.
        </p>
    </div>

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="true"
        />
    </x-filament-panels::form>

    <div class="mt-4 text-center text-sm text-slate-600">
        ¿Eres postulante o acudiente?
        <a href="{{ url('/') }}" class="font-semibold text-blue-800 hover:text-blue-900">
            Ingresa desde el portal
        </a>
    </div>
</x-filament-panels::page.simple>
