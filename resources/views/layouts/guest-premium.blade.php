<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Fundación Proseguir' }}</title>

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
        }

        .guest-premium-shell {
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.16), transparent 30rem),
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.14), transparent 28rem),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 48%, #eff6ff 100%);
        }

        .guest-premium-topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            border-bottom: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(14px);
        }

        .guest-premium-brand-title {
            font-size: 1.2rem;
            line-height: 1.5rem;
            font-weight: 900;
            letter-spacing: -0.025em;
            color: #0f172a;
        }

        .guest-premium-brand-subtitle {
            margin-top: .15rem;
            font-size: .9rem;
            font-weight: 600;
            color: #64748b;
        }

        .guest-premium-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: .85rem 1.25rem;
            font-size: 1rem;
            font-weight: 900;
            color: #334155;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
            transition: all .15s ease;
            text-decoration: none;
        }

        .guest-premium-btn-secondary:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .guest-premium-section {
            position: relative;
            overflow: hidden;
        }

        .guest-premium-bg {
            position: absolute;
            inset: 0;
        }

        .guest-premium-bg-base {
            height: 100%;
            width: 100%;
            background:
                radial-gradient(circle at top right, rgba(16, 185, 129, .22), transparent 22rem),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, .18), transparent 24rem),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 48%, #ecfdf5 100%);
        }

        .guest-premium-line {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #0f172a, #10b981);
        }

        .guest-premium-badge {
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

        .guest-premium-title {
    margin-top: 1.25rem;
    font-family: Figtree, Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
    font-size: clamp(2.6rem, 5vw, 4.5rem);
    line-height: 1;
    font-weight: 900;
    letter-spacing: -0.055em;
}

.guest-premium-title *,
.guest-premium-title-gradient {
    font-family: Figtree, Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
}

.guest-premium-title-gradient {
    background: linear-gradient(90deg, #1e3a8a, #0f172a, #047857);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.guest-premium-description {
    margin-top: 1.25rem;
    max-width: 42rem;
    font-family: Figtree, Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
    font-size: 1.15rem;
    line-height: 1.85rem;
    color: #64748b;
    font-weight: 500;
}

        .guest-premium-feature {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-size: .95rem;
            font-weight: 700;
            color: #64748b;
        }

        .guest-premium-card {
            border-radius: 28px;
            border: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 24px 70px rgba(15, 23, 42, .12);
            backdrop-filter: blur(14px);
            overflow: hidden;
        }

        .guest-premium-card-inner {
            padding: 1.75rem;
        }

        .guest-premium-hint {
            margin-top: 1rem;
            text-align: center;
            font-size: .85rem;
            line-height: 1.4rem;
            font-weight: 600;
            color: #64748b;
        }

        .guest-premium-footer {
            border-top: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, .9);
        }

        .guest-premium-footer a {
            font-weight: 800;
            color: #475569;
            transition: all .15s ease;
        }

        .guest-premium-footer a:hover {
            color: #0f172a;
        }

        @media (max-width: 768px) {
            .guest-premium-brand-text {
                display: none;
            }

            .guest-premium-card-inner {
                padding: 1.35rem;
            }
        }
        .guest-premium-shell,
.guest-premium-shell *,
.guest-premium-section,
.guest-premium-section *,
.guest-premium-card,
.guest-premium-card * {
    font-family: Figtree, Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
}
    </style>
</head>

<body class="guest-premium-shell antialiased">

<main class="min-h-screen">

    {{-- TOP BAR --}}
    <div class="guest-premium-topbar">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-4">
                    <img
                        src="{{ asset('brand/logo.png') }}"
                        alt="Fundación Proseguir"
                        class="h-12 w-auto sm:h-14 md:h-16"
                    >

                    <div class="guest-premium-brand-text leading-tight">
                        <div class="guest-premium-brand-title">
                            Becas, apoyos y kits escolares
                        </div>

                        <div class="guest-premium-brand-subtitle">
                            Fundación Proseguir
                        </div>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="guest-premium-btn-secondary">
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- BACKGROUND / CONTENT --}}
    <section class="guest-premium-section">
        <div class="guest-premium-bg">
            <div class="guest-premium-bg-base"></div>

            <div class="absolute -top-28 -right-24 h-80 w-80 rounded-full bg-emerald-200/40 blur-3xl"></div>
            <div class="absolute -bottom-28 -left-24 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/2 h-[520px] w-[520px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/40 blur-3xl"></div>
            <div class="guest-premium-line"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2">

                {{-- Lado izquierdo --}}
                <div class="hidden lg:block">
                    <span class="guest-premium-badge">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Acceso seguro
                    </span>

                    <h1 class="guest-premium-title">
                        <span class="guest-premium-title-gradient">
                            Impulsamos oportunidades educativas
                        </span>
                    </h1>

                    <p class="guest-premium-description">
                        Accede de forma segura para registrar información, adjuntar documentos y hacer seguimiento a tus solicitudes.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-6">
                        <span class="guest-premium-feature">
                            <span class="h-2.5 w-2.5 rounded-full bg-blue-800"></span>
                            Transparencia
                        </span>

                        <span class="guest-premium-feature">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            Acompañamiento
                        </span>

                        <span class="guest-premium-feature">
                            <span class="h-2.5 w-2.5 rounded-full bg-slate-700"></span>
                            Seguimiento
                        </span>
                    </div>
                </div>

                {{-- Contenido login/register --}}
                <div class="w-full">
                    <div class="mx-auto max-w-md">
                        <div class="guest-premium-card">
                            <div class="guest-premium-card-inner">
                                {{ $slot }}
                            </div>
                        </div>

                        <div class="guest-premium-hint">
                            ¿Problemas para ingresar? Verifica tu correo y contraseña, o crea una cuenta.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="guest-premium-footer">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                <span>
                    © {{ date('Y') }} Fundación Proseguir
                </span>

                <a href="/admin/login">
                    Admin / Gerencia
                </a>
            </div>
        </div>
    </footer>

</main>

</body>
</html>