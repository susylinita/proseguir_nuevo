<x-guest-premium-layout title="Iniciar sesión | Fundación Proseguir">

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="mb-6 text-xl font-bold text-slate-900">
        Iniciar sesión
    </h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email o cc--}}
        <div>
            <x-input-label for="email" value="Correo electrónico o Cédula" />
            <x-text-input id="email"
                class="block mt-1 w-full"
                type="text"
                name="email"
                :value="old('email')"
                required autofocus />
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

        {{-- Remember --}}
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center text-sm text-slate-600">
                <input type="checkbox" name="remember"
                       class="rounded border-slate-300 text-blue-800 focus:ring-blue-800">
                <span class="ms-2">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-blue-800 hover:text-blue-900"
                   href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center bg-slate-900 hover:bg-slate-700">
            Ingresar
        </x-primary-button>

        <div class="pt-2 text-center text-sm text-slate-600">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="font-semibold text-blue-800 hover:text-blue-900">
                Crear cuenta
            </a>
        </div>
    </form>

</x-guest-premium-layout>
