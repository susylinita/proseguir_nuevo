{{-- resources/views/components/guest-premium-layout.blade.php --}}
@props([
    'title' => 'Fundación Proseguir',
    'heroTitle' => 'Impulsamos oportunidades educativas',
    'heroDescription' => 'Accede de forma segura para registrar información, adjuntar documentos y hacer seguimiento a tus solicitudes.',
    'showHeroText' => true, // 👈 CLAVE
])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-50">
<main class="min-h-screen bg-slate-50 flex flex-col">

    {{-- TOP BAR --}}
    <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-4">
                    <img src="{{ asset('brand/logo.png') }}" class="h-12 sm:h-14 md:h-16 w-auto" alt="Fundación Proseguir">
                    <div class="leading-tight">
                        <div class="text-base sm:text-lg font-semibold text-slate-900">
                            Becas, apoyos y kits escolares
                        </div>
                        <div class="text-xs text-slate-500">
                            Fundación Proseguir
                        </div>
                    </div>
                </a>

                <a href="{{ url('/') }}"
                   class="hidden sm:inline-flex rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Volver al inicio
                </a>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <section class="relative flex-1 flex items-center overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0">
            <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
            <div class="absolute -top-28 -right-24 h-80 w-80 rounded-full bg-emerald-200/40 blur-3xl"></div>
            <div class="absolute -bottom-28 -left-24 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"></div>
        </div>

        <div class="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                {{-- HERO TEXT (solo si aplica) --}}
                @if($showHeroText)
                    <div class="hidden lg:block lg:col-span-7">
                        <h1 class="text-4xl xl:text-5xl font-extrabold tracking-tight">
                            <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                                {{ $heroTitle }}
                            </span>
                        </h1>

                        <p class="mt-4 max-w-xl text-base xl:text-lg text-slate-600 leading-relaxed">
                            {{ $heroDescription }}
                        </p>
                    </div>
                @endif

                {{-- CARD --}}
                <div class="{{ $showHeroText ? 'lg:col-span-5' : 'lg:col-span-12' }}">
                    <div class="{{ $showHeroText ? '' : 'mx-auto max-w-md' }}">
                        <div class="rounded-3xl border border-slate-200 bg-white/90 backdrop-blur shadow-xl">
                            <div class="p-6 sm:p-7">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-4 flex justify-between text-xs text-slate-500">
            <span>© {{ date('Y') }} Fundación Proseguir</span>
            <a href="/admin/login" class="hover:text-slate-900">Admin / Gerencia</a>
        </div>
    </footer>

</main>
</body>
</html>
