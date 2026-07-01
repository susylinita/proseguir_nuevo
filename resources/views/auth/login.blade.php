<x-guest-premium-layout title="Iniciar sesión | Fundación Proseguir">

    <style>
        .login-form-area {
            font-family: Figtree, Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #0f172a;
        }

        .login-title {
            margin-bottom: 1.5rem;
            font-size: 1.65rem;
            line-height: 2rem;
            font-weight: 900;
            letter-spacing: -0.035em;
            color: #0f172a;
        }

        .login-form-area label {
            font-size: 1rem !important;
            font-weight: 800 !important;
            color: #334155 !important;
        }

        .login-form-area input[type="text"],
        .login-form-area input[type="email"],
        .login-form-area input[type="password"] {
            width: 100%;
            border-radius: 14px !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #ffffff !important;
            padding: .85rem 1rem !important;
            font-size: 1rem !important;
            line-height: 1.5rem !important;
            font-weight: 600 !important;
            color: #0f172a !important;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05) !important;
            outline: none !important;
        }

        .login-form-area input[type="text"]:focus,
        .login-form-area input[type="email"]:focus,
        .login-form-area input[type="password"]:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.13) !important;
        }

        .login-form-area input[type="checkbox"] {
            border-radius: .35rem;
            border-color: #cbd5e1;
            color: #1d4ed8;
        }

        .login-link {
            font-size: .95rem;
            font-weight: 800;
            color: #1d4ed8;
            transition: all .15s ease;
        }

        .login-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .login-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border-radius: 14px;
            background: #0f172a;
            padding: .9rem 1.35rem;
            font-size: 1rem;
            font-weight: 900;
            color: #ffffff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
            transition: all .15s ease;
        }

        .login-btn-primary:hover {
            background: #020617;
            transform: translateY(-1px);
        }

        .login-register-text {
            padding-top: .5rem;
            text-align: center;
            font-size: .95rem;
            font-weight: 600;
            color: #64748b;
        }
    </style>

    <div class="login-form-area">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h2 class="login-title">
            Iniciar sesión
        </h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email o cédula --}}
            <div>
                <x-input-label for="email" value="Correo electrónico o Cédula" />

                <x-text-input
                    id="email"
                    class="mt-2 block w-full"
                    type="text"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" value="Contraseña" />

                <x-text-input
                    id="password"
                    class="mt-2 block w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <label class="inline-flex items-center text-sm font-semibold text-slate-600">
                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-slate-300 text-blue-700 focus:ring-blue-700"
                    >

                    <span class="ms-2">
                        Recordarme
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        class="login-link"
                        href="{{ route('password.request') }}"
                    >
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="login-btn-primary">
                Ingresar
            </button>

            <div class="login-register-text">
                ¿No tienes cuenta?

                <a href="{{ route('register') }}" class="login-link">
                    Crear cuenta
                </a>
            </div>
        </form>
    </div>

</x-guest-premium-layout>