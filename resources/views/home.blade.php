{{-- HOME Fundación Proseguir (elegante + intuitivo) --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fundación Proseguir</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .reveal, .focus-bounce { transition: none !important; animation: none !important; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity .6s ease, transform .6s ease;
            will-change: opacity, transform;
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* micro “bounce” premium (muy suave) */
        .focus-bounce {
            animation: focusBounce 700ms ease;
        }
        @keyframes focusBounce {
            0%   { transform: translateY(0) scale(1); }
            35%  { transform: translateY(-4px) scale(1.01); }
            70%  { transform: translateY(0) scale(0.998); }
            100% { transform: translateY(0) scale(1); }
        }
    </style>
</head>

<body class="antialiased bg-slate-50">
<main class="min-h-screen bg-slate-50">

    {{-- TOP BAR --}}
    <div class="sticky top-0 z-40 border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <div class="flex items-center gap-4">
                    <img
                        src="{{ asset('brand/logo.png') }}"
                        alt="Fundación Proseguir"
                        class="h-12 sm:h-14 md:h-16 w-auto"
                    >
                    <div class="leading-tight">
                        <div class="text-base sm:text-lg md:text-xl font-semibold text-slate-900">
                            Becas, apoyos y kits escolares
                        </div>
                        <div class="text-xs sm:text-sm text-slate-500">
                            Fundación Proseguir
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('portal.selector') }}"
                           class="inline-flex items-center rounded-md bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700 transition shadow-sm">
                            Ir a mi portal
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center rounded-md bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700 transition shadow-sm">
                            Iniciar sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0">
            <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>

            {{-- soft blobs --}}
            <div class="absolute -top-28 -right-24 h-80 w-80 rounded-full bg-emerald-200/40 blur-3xl"></div>
            <div class="absolute -bottom-28 -left-24 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"></div>

            {{-- corporate line --}}
            <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-800 to-emerald-500"></div>

            {{-- premium “shine” --}}
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 h-[520px] w-[520px] rounded-full bg-white/40 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                {{-- Copy --}}
                <div class="reveal is-visible">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Portal oficial
                    </span>

                    <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold tracking-tight">
                        <span class="bg-gradient-to-r from-blue-900 via-slate-900 to-emerald-700 bg-clip-text text-transparent">
                            Impulsamos oportunidades educativas
                        </span>
                    </h1>

                    <p class="mt-4 max-w-xl text-base sm:text-lg text-slate-600 leading-relaxed">
                        Elige el portal según tu necesidad. Podrás registrar información, adjuntar documentos y
                        consultar el estado de tus solicitudes de forma clara y segura.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        {{-- botón premium con micro efecto --}}
                        <button id="btnElegirPortal"
                                class="inline-flex items-center justify-center rounded-md bg-blue-800 px-7 py-3 text-sm sm:text-base font-semibold text-white hover:bg-blue-900 transition shadow-sm">
                            Elegir portal
                        </button>

                        @auth
                            <a href="{{ route('portal.selector') }}"
                               class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-7 py-3 text-sm sm:text-base font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                                Abrir selector
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-7 py-3 text-sm sm:text-base font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                                Crear cuenta
                            </a>
                        @endauth
                    </div>

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

                {{-- Slideshow (fade + zoom suave) --}}
                <div
                    class="relative"
                    x-data="{
                        index: 0,
                        images: [
                            '{{ asset('brand/hero/imagen_1.jpg') }}',
                            '{{ asset('brand/hero/imagen_2.jpg') }}',
                            '{{ asset('brand/hero/imagen_3.jpg') }}',
                            '{{ asset('brand/hero/imagen_4.jpg') }}',
                            '{{ asset('brand/hero/imagen_5.jpg') }}',
                            '{{ asset('brand/hero/imagen_6.jpg') }}',
                        ],
                        start() {
                            setInterval(() => {
                                this.index = (this.index + 1) % this.images.length
                            }, 9000)
                        }
                    }"
                    x-init="start()"
                >
                    <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white/80 backdrop-blur shadow-lg">
                        <div class="aspect-[16/11] sm:aspect-[16/10] lg:aspect-[16/11] relative">
                            <template x-for="(img, i) in images" :key="img">
                                <img
                                    :src="img"
                                    class="absolute inset-0 h-full w-full object-cover object-center transition duration-1000 ease-out"
                                    :class="index === i ? 'opacity-100 scale-[1.03]' : 'opacity-0 scale-100'"
                                    alt="Fundación Proseguir"
                                >
                            </template>

                            {{-- overlay suave --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-slate-900/10 to-transparent"></div>

                            {{-- etiqueta --}}
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-white/50 shadow-sm">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Historias reales • Educación
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- puntitos (más finos / premium) --}}
                    <div class="mt-3 flex items-center justify-center gap-2">
                        <template x-for="(img, i) in images" :key="i">
                            <button
                                type="button"
                                class="h-2.5 w-2.5 rounded-full transition"
                                :class="index === i ? 'bg-slate-900' : 'bg-slate-300 hover:bg-slate-400'"
                                @click="index = i"
                                aria-label="Cambiar imagen"
                            ></button>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- PORTALES (aparecen más abajo) --}}
    <section id="portales" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-14">
        <div class="scroll-mt-24"></div>

        {{-- Cómo funciona (compacto) --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="reveal rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold text-blue-800">Paso 1</div>
                <div class="mt-1 font-semibold text-slate-900">Selecciona el portal</div>
                <div class="mt-1 text-sm text-slate-600">Becas o Kits.</div>
            </div>
            <div class="reveal rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold text-emerald-700">Paso 2</div>
                <div class="mt-1 font-semibold text-slate-900">Adjunta documentos</div>
                <div class="mt-1 text-sm text-slate-600">Sube PDFs y completa datos.</div>
            </div>
            <div class="reveal rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-xs font-semibold text-slate-700">Paso 3</div>
                <div class="mt-1 font-semibold text-slate-900">Haz seguimiento</div>
                <div class="mt-1 text-sm text-slate-600">Consulta estados desde tu panel.</div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Becas --}}
            <div id="cardBecas" class="reveal rounded-2xl border border-slate-200 bg-white p-7 shadow-sm hover:shadow-md transition hover:-translate-y-0.5 hover:ring-1 hover:ring-slate-200">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Portal de Becas</h3>
                        <p class="mt-1 text-sm text-slate-600">Postulantes y becarios.</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">
                        Becas
                    </span>
                </div>

                <div class="mt-5 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('portal.select', ['portal' => 'postulantes']) }}"
                       class="flex-1 text-center rounded-md bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700 transition shadow-sm">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex-1 text-center rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Registrarme
                    </a>
                </div>
            </div>

            {{-- Kits --}}
            <div id="cardKits" class="reveal rounded-2xl border border-slate-200 bg-white p-7 shadow-sm hover:shadow-md transition hover:-translate-y-0.5 hover:ring-1 hover:ring-slate-200">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Portal de Kits Escolares</h3>
                        <p class="mt-1 text-sm text-slate-600">Para acudientes.</p>
                    </div>
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-800">
                        Kits
                    </span>
                </div>

                <div class="mt-5 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('portal.select', ['portal' => 'kits']) }}"
                       class="flex-1 text-center rounded-md bg-blue-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-900 transition shadow-sm">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex-1 text-center rounded-md border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Registrarme
                    </a>
                </div>
            </div>
        </div>

    </section>

    {{-- FOOTER (Admin solo abajo a la derecha) --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="text-sm text-slate-600">
                    <div class="font-semibold text-slate-900">Fundación Proseguir</div>
                    <div class="text-xs text-slate-500">© {{ date('Y') }} Todos los derechos reservados.</div>
                </div>

                <div class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ route('portal.selector') }}" class="text-slate-600 hover:text-slate-900">Selector de portal</a>
                    @endauth
                    <a href="/admin/login" class="text-slate-600 hover:text-slate-900">Admin / Gerencia</a>
                </div>
            </div>
        </div>
    </footer>

</main>

{{-- Reveal on scroll + micro animación del botón “Elegir portal” --}}
<script>
    (function () {
        // reveal
        const els = document.querySelectorAll('.reveal');
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) e.target.classList.add('is-visible');
            });
        }, { threshold: 0.12 });
        els.forEach(el => io.observe(el));

        // botón “Elegir portal” -> scroll + foco suave
        const btn = document.getElementById('btnElegirPortal');
        btn?.addEventListener('click', () => {
            const target = document.getElementById('portales');
            if (!target) return;

            target.scrollIntoView({ behavior: 'smooth' });

            // micro “focus” a las tarjetas luego del scroll
            setTimeout(() => {
                const c1 = document.getElementById('cardBecas');
                const c2 = document.getElementById('cardKits');
                c1?.classList.add('focus-bounce');
                c2?.classList.add('focus-bounce');
                setTimeout(() => {
                    c1?.classList.remove('focus-bounce');
                    c2?.classList.remove('focus-bounce');
                }, 900);
            }, 650);
        });
    })();
</script>

</body>
</html>
