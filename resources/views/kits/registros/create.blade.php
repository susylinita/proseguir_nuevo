<x-app-kits-layout>
   <x-slot name="header">
    <div class="rounded-2xl p-8 
                bg-gradient-to-r from-slate-100 via-slate-200 to-emerald-100 
                border border-slate-200 shadow-sm">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

            {{-- Lado izquierdo --}}
            <div>

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 
                            px-4 py-1.5 rounded-full 
                            bg-white/70 backdrop-blur 
                            border border-slate-300 
                            text-xs font-medium text-slate-700 shadow-sm">
                    🎒 Nueva solicitud de kit
                </div>

                {{-- Título --}}
                <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-slate-900">
                    Registro Kits Escolares
                </h1>

                {{-- Descripción --}}
                <p class="mt-3 text-slate-700 max-w-2xl leading-relaxed">
                    Diligencia la información del colaborador y del niño beneficiario
                    para solicitar el kit escolar correspondiente.
                </p>

                <p class="mt-3 text-sm text-slate-500">
                    Puedes registrar más de un kit si tienes varios niños beneficiarios.
                </p>
            </div>

            {{-- Botón derecha --}}
            <div class="flex items-center gap-4">

                <a href="{{ route('kits.dashboard') }}"
                   class="inline-flex items-center gap-2 
                          bg-white border border-slate-300 
                          text-slate-700 px-6 py-3 
                          rounded-xl font-medium 
                          hover:bg-slate-50 transition">
                    ← Volver al dashboard
                </a>

            </div>

        </div>
    </div>
</x-slot>



    <div class="py-10">
        <div class="max-w-5xl mx-auto px-6">

            <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-indigo-700 via-slate-900 to-emerald-500"></div>

                <div class="p-10 space-y-10 text-slate-900">

                    @if ($errors->any())
                        <div class="rounded-xl border border-red-200 bg-red-50 p-6">
                            <div class="text-sm font-semibold text-red-800">
                                Revisa los siguientes campos:
                            </div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kits.registros.store') }}">
                        @csrf

                        {{-- ========================= --}}
                        {{-- DATOS DEL COLABORADOR --}}
                        {{-- ========================= --}}
                        <div class="space-y-6">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">
                                Información del colaborador
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">
                                        Nombre completo
                                    </label>
                                    <input name="colaborador_nombre" type="text" required
                                           value="{{ old('colaborador_nombre') }}"
                                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">
                                        Documento
                                    </label>
                                    <input name="colaborador_documento" type="text" required
                                           value="{{ old('colaborador_documento') }}"
                                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition">
                                </div>

                                <div>
    <label for="linea_negocio" class="block text-sm font-medium text-gray-700">
        Línea de negocio
    </label>

    <select
        id="linea_negocio"
        name="linea_negocio"
        required
        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
    >
        <option value="">Seleccione una opción</option>
        <option value="PROSEGUIR SAS" {{ old('linea_negocio') == 'PROSEGUIR SAS' ? 'selected' : '' }}>PROSEGUIR SAS</option>
        <option value="PROSEGUIR SOLUCIONES DE LIQUIDEZ SAS" {{ old('linea_negocio') == 'PROSEGUIR SOLUCIONES DE LIQUIDEZ SAS' ? 'selected' : '' }}>PROSEGUIR SOLUCIONES DE LIQUIDEZ SAS</option>
        <option value="PROSEGUIR INMOBILIARIA SAS" {{ old('linea_negocio') == 'PROSEGUIR INMOBILIARIA SAS' ? 'selected' : '' }}>PROSEGUIR INMOBILIARIA SAS</option>
        <option value="SITEI SAS" {{ old('linea_negocio') == 'SITEI SAS' ? 'selected' : '' }}>SITEI SAS</option>
        <option value="SMART GAME SG SAS" {{ old('linea_negocio') == 'SMART GAME SG SAS' ? 'selected' : '' }}>SMART GAME SG SAS</option>
        <option value="EVOLUCIÓN INTELIGENTE SAS" {{ old('linea_negocio') == 'EVOLUCIÓN INTELIGENTE SAS' ? 'selected' : '' }}>EVOLUCIÓN INTELIGENTE SAS</option>
    </select>

    @error('linea_negocio')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">
                                        Cargo
                                    </label>
                                    <input name="area" type="text" required
                                           value="{{ old('area') }}"
                                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition">
                                </div>

                            </div>
                        </div>

                        {{-- ========================= --}}
                        {{-- DATOS DEL NIÑO --}}
                        {{-- ========================= --}}
                        <div class="space-y-6 pt-6 border-t border-slate-200">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">
                                Información del niño
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">
                                        Nombre completo
                                    </label>
                                    <input name="nino_nombre" type="text" required
                                           value="{{ old('nino_nombre') }}"
                                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition">
                                </div>

                            

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">
                                        Edad
                                    </label>
                                    <input name="edad" type="number" min="1" required
                                           value="{{ old('edad') }}"
                                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">
                                        Grado
                                    </label>
                                    <input name="grado" type="text" required
                                           value="{{ old('grado') }}"
                                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">
                                        Institución
                                    </label>
                                    <input name="institucion" type="text" required
                                           value="{{ old('institucion') }}"
                                           class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition">
                                </div>

                            </div>
                        </div>
                        <div class="form-check mt-3">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="acepta_tratamiento_datos" 
                            id="acepta_tratamiento_datos" 
                            value="1"
                            {{ old('acepta_tratamiento_datos') ? 'checked' : '' }}
                            required
                        >

                        <label class="form-check-label" for="acepta_tratamiento_datos">
                            He leído y Acepto la 
                            <a href="{{ asset('storage/politica-datos.pdf') }}" 
                                target="_blank" 
                                style="color: #0d6efd; text-decoration: underline;">
                                    Política de Tratamiento de Datos Personales
                                </a>

                        </label>

                        @error('acepta_tratamiento_datos')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                        {{-- BOTONES --}}
                        <div class="flex justify-end gap-4 pt-8">
                            <a href="{{ route('kits.dashboard') }}"
                               class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-6 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-semibold text-white hover:bg-slate-700 transition shadow-sm">
                                Guardar registro
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-kits-layout>
