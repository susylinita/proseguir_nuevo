<nav x-data="{ open: false }" class="relative z-[9999] bg-white/80 backdrop-blur border-b border-slate-200">    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LEFT --}}
            <div class="flex items-center">
                {{-- Logo Proseguir --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('brand/logo.png') }}" alt="Fundación Proseguir" class="h-9 w-auto">
                    @php $portal = session('portal'); @endphp

                        @if($portal === 'postulantes')
                            <span class="hidden sm:inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">
                                Becas
                            </span>
                        @elseif($portal === 'kits')
                            <span class="hidden sm:inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-800">
                                Kits
                            </span>
                        @endif

                </a>

                {{-- Links (desktop) --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    @php
                        $portal = session('portal'); // 'kits' | 'postulantes' | null
                    @endphp

                    {{-- POSTULANTES --}}
                    @if($portal === 'postulantes')
                        <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('student.postulaciones.index')" :active="request()->routeIs('student.postulaciones.*')">
                            Mis postulaciones
                        </x-nav-link>
                    @endif

                    {{-- KITS --}}
                    @if($portal === 'kits')
                        <x-nav-link :href="route('kits.dashboard')" :active="request()->routeIs('kits.dashboard')">
                            Dashboard Kits
                        </x-nav-link>

                        <x-nav-link :href="route('kits.registros.index')" :active="request()->routeIs('kits.registros.*')">
                            Mis registros
                        </x-nav-link>

                        <x-nav-link :href="route('kits.registros.create')" :active="request()->routeIs('kits.registros.create')">
                            Registrar niño
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- RIGHT (desktop) --}}
            <div class="relative z-[99999] hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-600 bg-white/50 hover:text-slate-900 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('portal.selector')">
                            Cambiar portal
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- HAMBURGER --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @php $portal = session('portal'); @endphp

            @if($portal === 'postulantes')
                <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('student.postulaciones.index')" :active="request()->routeIs('student.postulaciones.*')">
                    Mis postulaciones
                </x-responsive-nav-link>
            @endif

            @if($portal === 'kits')
                <x-responsive-nav-link :href="route('kits.dashboard')" :active="request()->routeIs('kits.dashboard')">
                    Dashboard Kits
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('kits.registros.index')" :active="request()->routeIs('kits.registros.*')">
                    Mis registros
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('kits.registros.create')" :active="request()->routeIs('kits.registros.create')">
                    Registrar niño
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('portal.selector')">
                    Cambiar portal
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
