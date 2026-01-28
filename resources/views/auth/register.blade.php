<x-guest-premium-layout title="Crear cuenta | Fundación Proseguir">

    <h2 class="mb-6 text-xl font-bold text-slate-900">
        Crear cuenta
    </h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <x-input-label for="name" value="Nombre completo" />
            <x-text-input id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm --}}
        <div>
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required />
        </div>

        <x-primary-button class="w-full justify-center bg-blue-800 hover:bg-blue-900">
            Crear cuenta
        </x-primary-button>

        <div class="pt-2 text-center text-sm text-slate-600">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-semibold text-blue-800 hover:text-blue-900">
                Iniciar sesión
            </a>
        </div>
    </form>

</x-guest-premium-layout>
