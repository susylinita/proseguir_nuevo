<x-guest-premium-admin-layout title="Admin | Iniciar sesión - Fundación Proseguir">

    {{-- (Opcional) Mensaje de estado si Filament lo usa --}}
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    <h2 class="mb-6 text-xl font-bold text-slate-900">
        Iniciar sesión
    </h2>

    {{-- Filament Login es Livewire: NO uses route('login') --}}
    <form wire:submit="authenticate" class="space-y-4">

        {{-- Renderiza campos oficiales de Filament (email, password, remember, etc.) --}}
        {{ $this->form }}

        {{-- Botón igual al login normal --}}
        <x-primary-button class="w-full justify-center bg-slate-900 hover:bg-slate-700">
            Ingresar
        </x-primary-button>

        {{-- Abajo, en admin NO mostramos "Crear cuenta" (recomendado) --}}
        <div class="pt-2 text-center text-sm text-slate-600">
            ¿Eres postulante o acudiente?
            <a href="{{ url('/login') }}" class="font-semibold text-blue-800 hover:text-blue-900">
                Ingresa desde el portal
            </a>
        </div>

    </form>

</x-guest-premium-admin-layout>
