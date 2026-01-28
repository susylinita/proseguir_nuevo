<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Fundación Proseguir' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }
    </style>
</head>

<body class="antialiased bg-slate-50">
<main class="min-h-screen bg-slate-50">

    {{-- TOP BAR --}}
    <div class="sticky top-0 z-40 border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-4">
                    <img src="{{ asset('brand/logo.png') }}" alt="Fundación Proseguir" class="h-12 sm:h-14 md:h-16 w-auto">
                    <div class="leading-tight">
                        <div class="text-base sm:text-lg md:text-xl font-semibold text-slate-900">
                            Becas, apoyos y kits escolares
                        </div>
                        <div class="text-xs sm:text-sm text-slate-500">
                            Fundación Proseguir
                        </div>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}"
                       class="hidden sm:inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- BACKGROUND (mismo estilo del home) --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
            <div class="absolute -top-28 -right-24 h-80 w-80 rounded-full bg-emerald-200/40 blur-3xl"></div>
            <div class="absolute -bottom-28 -left-24 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"></div>
            <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-800 to-emerald-500"></div>
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 h-[520px] w-[520px] rounded-full bg-white/40 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                {{-- Lado izquierdo: mensaje breve --}}
                <div class="hidden lg:block">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Acceso seguro
                    </span>

                    <h1 class="mt-6 text-4xl font-extrabold tracking-tight">
                        <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                            Bienvenido(a)
                        </span>
                    </h1>

                    <p class="mt-4 max-w-md text-base text-slate-600 leading-relaxed">
                        Aquí podrás gestionar tu información, adjuntar documentos y hacer seguimiento a tus solicitudes.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-6 text-sm text-slate-500">
                        <span class="inline-flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-blue-800"></span> Transparencia
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Acompañamiento
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-slate-700"></span> Seguimiento
                        </span>
                    </div>
                </div>

                {{-- Contenido (login/register) --}}
                <div class="w-full">
                    <div class="mx-auto max-w-md">
                        <div class="rounded-3xl border border-slate-200 bg-white/90 backdrop-blur shadow-lg">
                            <div class="p-6 sm:p-7">
                                {{ $slot }}
                            </div>
                        </div>

                        {{-- hint footer pequeño --}}
                        <div class="mt-4 text-xs text-slate-500 text-center">
                            ¿Problemas para ingresar? Verifica tu correo y contraseña, o crea una cuenta.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between text-xs text-slate-500">
                <span>© {{ date('Y') }} Fundación Proseguir</span>
                <a href="/admin/login" class="text-slate-600 hover:text-slate-900">Admin / Gerencia</a>
            </div>
        </div>
    </footer>

</main>
</body>
</html>
