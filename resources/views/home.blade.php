{{-- HOME Fundación Proseguir --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fundación Proseguir</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Figtree, Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #0f172a;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .reveal,
            .focus-bounce {
                transition: none !important;
                animation: none !important;
            }
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

        .home-shell {
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.16), transparent 30rem),
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.14), transparent 28rem),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 48%, #eff6ff 100%);
        }

        .home-topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            border-bottom: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(14px);
        }

        .home-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: #1d4ed8;
            padding: .9rem 1.35rem;
            font-size: 1rem;
            font-weight: 900;
            color: #ffffff;
            box-shadow: 0 12px 28px rgba(37, 99, 235, .22);
            transition: all .15s ease;
            text-decoration: none;
            text-align: center;
        }

        .home-btn-primary:hover {
            background: #1e40af;
            transform: translateY(-1px);
        }

        .home-btn-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: #0f172a;
            padding: .9rem 1.35rem;
            font-size: 1rem;
            font-weight: 900;
            color: #ffffff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
            transition: all .15s ease;
            text-decoration: none;
            text-align: center;
        }

        .home-btn-dark:hover {
            background: #020617;
            transform: translateY(-1px);
        }

        .home-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: .9rem 1.35rem;
            font-size: 1rem;
            font-weight: 900;
            color: #334155;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
            transition: all .15s ease;
            text-decoration: none;
            text-align: center;
        }

        .home-btn-secondary:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .home-hero {
            position: relative;
            overflow: hidden;
            border-radius: 32px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .10);
        }

        .home-hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(16, 185, 129, .22), transparent 22rem),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, .18), transparent 24rem),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 48%, #ecfdf5 100%);
        }

        .home-hero-line {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #0f172a, #10b981);
        }

        .home-hero-content {
            position: relative;
            padding: 3rem;
        }

        .home-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .86);
            padding: .5rem .95rem;
            font-size: .9rem;
            font-weight: 900;
            color: #334155;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .06);
        }

        .home-title {
            margin-top: 1.25rem;
            font-size: clamp(2.6rem, 5vw, 4.5rem);
            line-height: 1;
            font-weight: 900;
            letter-spacing: -0.055em;
        }

        .home-title-gradient {
            background: linear-gradient(90deg, #1e3a8a, #0f172a, #047857);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .home-description {
            margin-top: 1.25rem;
            max-width: 42rem;
            font-size: 1.15rem;
            line-height: 1.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .home-image-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 22px 55px rgba(15, 23, 42, .16);
        }

        .home-image-badge {
            position: absolute;
            left: 1.25rem;
            bottom: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .90);
            padding: .55rem .9rem;
            font-size: .85rem;
            font-weight: 900;
            color: #334155;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .14);
        }

        .home-video-card {
            position: relative;
            overflow: hidden;
            border-radius: 32px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .10);
        }

        .home-video-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(16, 185, 129, .18), transparent 22rem),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, .14), transparent 24rem),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 48%, #eff6ff 100%);
        }

        .home-video-line {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #0f172a, #10b981);
        }

        .home-video-content {
            position: relative;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        .home-video-title {
            margin-top: 1rem;
            font-size: clamp(1.8rem, 3vw, 2.7rem);
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: -0.045em;
            color: #0f172a;
        }

        .home-video-description {
            margin-top: 1rem;
            max-width: 44rem;
            font-size: 1.05rem;
            line-height: 1.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .home-video-wrapper {
            overflow: hidden;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            background: #0f172a;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .16);
        }

        .home-video {
            display: block;
            width: 100%;
            height: auto;
            max-height: 520px;
            background: #0f172a;
        }

        .home-step-card,
        .home-portal-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 1.6rem;
            box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
            transition: all .15s ease;
        }

        .home-step-card:hover,
        .home-portal-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .10);
        }

        .home-step-number {
            font-size: .9rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #1d4ed8;
        }

        .home-step-title,
        .home-portal-title {
            margin-top: .6rem;
            font-size: 1.2rem;
            font-weight: 900;
            color: #0f172a;
        }

        .home-step-text,
        .home-portal-text {
            margin-top: .5rem;
            font-size: 1rem;
            line-height: 1.7rem;
            color: #64748b;
            font-weight: 500;
        }

        .focus-bounce {
            animation: focusBounce 700ms ease;
        }

        @keyframes focusBounce {
            0% { transform: translateY(0) scale(1); }
            35% { transform: translateY(-4px) scale(1.01); }
            70% { transform: translateY(0) scale(.998); }
            100% { transform: translateY(0) scale(1); }
        }

        @media (min-width: 1024px) {
            .home-video-content {
                grid-template-columns: 0.8fr 1.2fr;
                align-items: center;
                padding: 3rem;
            }
        }

        @media (max-width: 768px) {
            .home-hero-content {
                padding: 1.6rem;
            }

            .home-topbar .brand-text {
                display: none;
            }

            .home-video-content {
                padding: 1.6rem;
            }
        }
    </style>
</head>

<body class="antialiased bg-slate-50 font-sans">
<main class="home-shell">

    {{-- TOP BAR --}}
    <div class="home-topbar">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <div class="flex items-center gap-4">
                    <img
                        src="{{ asset('brand/logo.png') }}"
                        alt="Fundación Proseguir"
                        class="h-12 w-auto sm:h-14 md:h-16"
                    >

                    <div class="brand-text leading-tight">
                        <div class="text-base font-black text-slate-900 sm:text-lg md:text-xl">
                            Becas, apoyos y kits escolares
                        </div>
                        <div class="text-xs font-semibold text-slate-500 sm:text-sm">
                            Fundación Proseguir
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('portal.selector') }}" class="home-btn-dark">
                            Ir a mi portal
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="home-btn-dark">
                            Iniciar sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- HERO --}}
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
        <div class="home-hero">
            <div class="home-hero-bg"></div>
            <div class="home-hero-line"></div>

            <div class="home-hero-content">
                <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">

                    {{-- Copy --}}
                    <div class="reveal is-visible">
                        <span class="home-badge">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Portal oficial
                        </span>

                        <h1 class="home-title">
                            <span class="home-title-gradient">
                                Impulsamos oportunidades educativas
                            </span>
                        </h1>

                        <p class="home-description">
                            Elige el portal según tu necesidad. Podrás registrar información, adjuntar documentos y consultar el estado de tus solicitudes de forma clara y segura.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <button id="btnElegirPortal" type="button" class="home-btn-primary">
                                Elegir portal
                            </button>

                            @auth
                                <a href="{{ route('portal.selector') }}" class="home-btn-secondary">
                                    Abrir selector
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="home-btn-secondary">
                                    Crear cuenta
                                </a>
                            @endauth
                        </div>

                        <div class="mt-8 flex flex-wrap gap-6 text-sm font-bold text-slate-500">
                            <span class="inline-flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-blue-800"></span>
                                Transparencia
                            </span>

                            <span class="inline-flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                Acompañamiento
                            </span>

                            <span class="inline-flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-slate-700"></span>
                                Seguimiento
                            </span>
                        </div>
                    </div>

                    {{-- Slideshow --}}
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
                        <div class="home-image-card">
                            <div class="relative aspect-[16/11] sm:aspect-[16/10] lg:aspect-[16/11]">
                                <template x-for="(img, i) in images" :key="img">
                                    <img
                                        :src="img"
                                        class="absolute inset-0 h-full w-full object-cover object-center transition duration-1000 ease-out"
                                        :class="index === i ? 'opacity-100 scale-[1.03]' : 'opacity-0 scale-100'"
                                        alt="Fundación Proseguir"
                                    >
                                </template>

                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-slate-900/10 to-transparent"></div>

                                <div class="home-image-badge">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Historias reales • Educación
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-center gap-2">
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
        </div>
    </section>

    

    {{-- PORTALES --}}
    <section id="portales" class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
        <div class="scroll-mt-24"></div>

        {{-- Cómo funciona --}}
        <div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3">
            <div class="reveal home-step-card">
                <div class="home-step-number">Paso 1</div>
                <div class="home-step-title">Selecciona el portal</div>
                <div class="home-step-text">Becas o Kits.</div>
            </div>

            <div class="reveal home-step-card">
                <div class="home-step-number text-emerald-700">Paso 2</div>
                <div class="home-step-title">Adjunta documentos</div>
                <div class="home-step-text">Sube PDFs y completa datos.</div>
            </div>

            <div class="reveal home-step-card">
                <div class="home-step-number text-slate-700">Paso 3</div>
                <div class="home-step-title">Haz seguimiento</div>
                <div class="home-step-text">Consulta estados desde tu panel.</div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">
            {{-- Becas --}}
            <div id="cardBecas" class="reveal home-portal-card">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="home-portal-title">
                            Portal de Becas
                        </h3>
                        <p class="home-portal-text">
                            Postulantes y becarios.
                        </p>
                    </div>

                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-800">
                        Becas
                    </span>
                </div>

                <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('portal.select', ['portal' => 'postulantes']) }}" class="home-btn-primary flex-1">
                        Ingresar
                    </a>

                    <a href="{{ route('register') }}" class="home-btn-secondary flex-1">
                        Registrarme
                    </a>
                </div>
            </div>

            {{-- Kits --}}
            <div id="cardKits" class="reveal home-portal-card">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="home-portal-title">
                            Portal de Kits Escolares
                        </h3>
                        <p class="home-portal-text">
                            Para acudientes.
                        </p>
                    </div>

                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-800">
                        Kits
                    </span>
                </div>

                <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('portal.select', ['portal' => 'kits']) }}" class="home-btn-primary flex-1">
                        Ingresar
                    </a>

                    <a href="{{ route('register') }}" class="home-btn-secondary flex-1">
                        Registrarme
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- VIDEO EXPLICATIVO --}}
    <section class="mx-auto max-w-7xl px-4 pb-10 sm:px-6 lg:px-8">
        <div class="reveal home-video-card">
            <div class="home-video-line"></div>

            <div class="home-video-content">
                <div>
                    <span class="home-badge">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Guía rápida
                    </span>

                    <h2 class="home-video-title">
                        Aprende cómo registrarte en el portal
                    </h2>

                    <p class="home-video-description">
                        Mira este video explicativo para conocer el proceso de registro, selección del portal, ingreso de información y carga de documentos.
                    </p>

                    <!-- <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="home-btn-primary">
                            Crear cuenta
                        </a>

                        <button id="btnVerPortales" type="button" class="home-btn-secondary">
                            Ver opciones de portal
                        </button>
                    </div> -->
                </div>

                <div class="home-video-wrapper">
                    <video
                        controls
                        preload="metadata"
                        class="home-video"
                    >
                        <source src="{{ asset('videos/video_registro_becas.mp4') }}" type="video/mp4">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                </div>
            </div>
        </div>
    </section>
    
    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div class="text-sm text-slate-600">
                    <div class="font-black text-slate-900">
                        Fundación Proseguir
                    </div>
                    <div class="text-xs font-semibold text-slate-500">
                        © {{ date('Y') }} Todos los derechos reservados.
                    </div>
                </div>

                <div class="flex items-center gap-4 text-sm font-bold">
                    @auth
                        <a href="{{ route('portal.selector') }}" class="text-slate-600 hover:text-slate-900">
                            Selector de portal
                        </a>
                    @endauth

                    <a href="/admin/login" class="text-slate-600 hover:text-slate-900">
                        Admin / Gerencia
                    </a>
                </div>
            </div>
        </div>
    </footer>

</main>

<script>
    (function () {
        const els = document.querySelectorAll('.reveal');

        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.12 });

        els.forEach(el => io.observe(el));

        const scrollToPortales = () => {
            const target = document.getElementById('portales');

            if (!target) return;

            target.scrollIntoView({ behavior: 'smooth' });

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
        };

        document.getElementById('btnElegirPortal')?.addEventListener('click', scrollToPortales);
        document.getElementById('btnVerPortales')?.addEventListener('click', scrollToPortales);
    })();
</script>

</body>
</html>