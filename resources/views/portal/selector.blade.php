<x-app-layout>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-6">

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Línea superior elegante --}}
                <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-900 to-emerald-500"></div>

                <div class="p-10 space-y-8">

                    <p class="text-slate-700 text-lg">
                        Elige a qué portal deseas ingresar:
                    </p>

                    <form method="POST" action="{{ route('portal.selector.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Portal Postulantes --}}
                            <button type="submit" name="portal" value="postulantes"
                                class="group text-left rounded-2xl border border-slate-200 p-8 
                                       transition-all duration-300 hover:-translate-y-1 hover:shadow-md">

                                <div class="text-xs font-semibold text-blue-800 uppercase tracking-wider">
                                    Portal académico
                                </div>

                                <h3 class="mt-3 text-xl font-bold text-slate-900">
                                    Postulaciones / Becas
                                </h3>

                                <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                    Postulación universitaria, inicio de carrera o renovación de beca.
                                </p>

                                <div class="mt-6 text-sm font-semibold text-blue-800 group-hover:text-blue-900">
                                    Ingresar →
                                </div>
                            </button>

                            {{-- Portal Kits --}}
                            <button type="submit" name="portal" value="kits"
                                class="group text-left rounded-2xl border border-slate-200 p-8 
                                       transition-all duration-300 hover:-translate-y-1 hover:shadow-md">

                                <div class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">
                                    Portal social
                                </div>

                                <h3 class="mt-3 text-xl font-bold text-slate-900">
                                    Kits Escolares
                                </h3>

                                <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                    Registro de niños y cargue de documentos para kits escolares.
                                </p>

                                <div class="mt-6 text-sm font-semibold text-emerald-700 group-hover:text-emerald-800">
                                    Ingresar →
                                </div>
                            </button>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
