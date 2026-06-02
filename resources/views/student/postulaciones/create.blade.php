<x-app-layout>
    <x-slot name="header">
    <div class="rounded-2xl p-8 
                bg-gradient-to-r from-slate-100 via-slate-200 to-blue-100 
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
                    ✍️ Nueva solicitud
                </div>

                {{-- Título --}}
                <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-slate-900">
                    Crear postulación
                </h1>

                {{-- Descripción --}}
                <p class="mt-3 text-slate-700 max-w-2xl leading-relaxed">
                    Completa cuidadosamente la información requerida para enviar tu solicitud
                    a revisión de coordinación y gerencia.
                </p>

                <p class="mt-3 text-sm text-slate-500">
                    Asegúrate de adjuntar todos los documentos obligatorios.
                </p>
            </div>

            {{-- Botón derecha --}}
            <div class="flex items-center gap-4">

                <a href="{{ route('student.postulaciones.index') }}"
                   class="inline-flex items-center gap-2 
                          bg-white border border-slate-300 
                          text-slate-700 px-6 py-3 
                          rounded-xl font-medium 
                          hover:bg-slate-50 transition">
                    ← Volver a mis postulaciones
                </a>

            </div>

        </div>
    </div>
</x-slot>


    <div class="max-w-5xl mx-auto py-10 px-6">

            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="text-sm font-semibold text-red-800">Revisa los campos:</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
            <div class="p-8 text-slate-900"
                     x-data="{
                        tipo: '{{ old('tipo_postulacion', 'primer_semestre') }}',
                        cuentaActualizada: {{ old('cuenta_actualizada', 0) ? 'true' : 'false' }}
                     }">

                    {{-- Bloque informativo (solo lectura) --}}
                    <div class="rounded-md border border-gray-200 bg-gray-50 p-4 text-sm">
                        <div class="text-xs uppercase tracking-wider text-gray-500 mb-2">
                            Datos del postulante
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-gray-500">Nombre</div>
                                <div class="font-medium text-gray-900">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>

                            <div>
                                <div class="text-gray-500">Correo electrónico</div>
                                <div class="font-medium text-gray-900">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 text-xs text-gray-500">
                            Estos datos se toman automáticamente de tu cuenta y no se pueden modificar desde la postulación.
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('student.postulaciones.store') }}"
                          enctype="multipart/form-data"
                          class="mt-6 space-y-6">
                        @csrf

                        {{-- Tipo de postulación --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tipo de postulación
                            </label>
                            <select name="tipo_postulacion"
                                    x-model="tipo"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="primer_semestre">Ingreso a primer semestre (primera vez)</option>
                                <option value="otro_semestre">Ingreso a otro semestre (primera vez)</option>
                                <option value="renovacion">Renovación (ya becado)</option>
                            </select>

                            <p class="mt-2 text-xs text-gray-500">
                                La renovación se maneja como una nueva postulación.
                            </p>
                        </div>

                        {{-- Datos personales --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Datos personales
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                                    <input name="fecha_nacimiento" type="date"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('fecha_nacimiento') }}">
                                </div>

                                <div>
                        <label for="tipo_documento" class="block text-sm font-medium text-gray-700">
                            Tipo de documento
                        </label>

                        <select
                            id="tipo_documento"
                            name="tipo_documento"
                            required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Seleccione una opción</option>
                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de ciudadanía</option>
                            <option value="TI" {{ old('tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de identidad</option>
                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de extranjería</option>
                            <option value="PAS" {{ old('tipo_documento') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="RC" {{ old('tipo_documento') == 'RC' ? 'selected' : '' }}>Registro civil</option>
                        </select>

                        @error('tipo_documento')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de documento</label>
                                    <input name="documento_identidad" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('documento_identidad') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono celular</label>
                                    <input name="telefono_celular" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_celular') }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono fijo (opcional)</label>
                                    <input name="telefono_fijo" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_fijo') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dirección (opcional)</label>
                                    <input name="direccion" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('direccion') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Barrio (opcional)</label>
                                    <input name="barrio" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('barrio') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Género</label>
                                    <select name="genero"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="F" @selected(old('genero')==='F')>F</option>
                                        <option value="M" @selected(old('genero')==='M')>M</option>
                                        <option value="Otro" @selected(old('genero')==='Otro')>Otro</option>
                                        <option value="Prefiero no decir" @selected(old('genero')==='Prefiero no decir')>Prefiero no decir</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Acudiente --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Datos del acudiente
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nombre acudiente</label>
                                    <input name="nombre_acudiente" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('nombre_acudiente') }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono acudiente</label>
                                    <input name="telefono_acudiente" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_acudiente') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Estudios (según tipo) --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Estudios
                            </div>

                            {{-- Primer semestre --}}
                            <div x-show="tipo == 'primer_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad a la que quiere aplicar</label>
                                        <input name="universidad_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_aplica') }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_aplica') }}">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500">
                                    Recuerda: la beca aplica únicamente para programas de <strong>pregrado</strong>.
                                </p>
                            </div>

                            {{-- Otro semestre (estudiante activo) --}}
                            <div x-show="tipo == 'otro_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad (opcional)</label>
                                        <input name="universidad_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_actual') }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_actual') }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Semestre en curso</label>
                                        <input name="semestre_en_curso" type="number" min="1" max="12"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('semestre_en_curso') }}">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500">
                                    La beca cubre desde el semestre actual en adelante (no retroactiva).
                                </p>
                            </div>

                            {{-- Renovación --}}
                            <div x-show="tipo == 'renovacion'" x-cloak class="space-y-4">
                                <p class="text-sm text-gray-700">
                                    Para renovación, sube únicamente: <strong>certificado de notas</strong> y <strong>recibo de matrícula</strong>.
                                    Si cambiaste la cuenta bancaria, actívalo y actualiza los datos.
                                </p>

        

                                <label class="inline-flex items-center text-sm text-gray-700">
                                    <input type="checkbox" name="cuenta_actualizada" value="1"
                                           x-model="cuentaActualizada"
                                           class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                                    <span class="ms-2">Actualicé mis datos bancarios</span>
                                </label>
                            </div>
                        </div>

                        {{-- Datos bancarios --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Datos bancarios
                            </div>

                            <p class="text-xs text-gray-500 mb-4">
                                Si es tu primera beca, diligencia estos datos. Si es renovación, solo actualiza si cambiaste de cuenta.
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                 :class="(tipo === 'renovacion' && !cuentaActualizada) ? 'opacity-50 pointer-events-none' : ''">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Banco</label>
                                    <input name="banco" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('banco') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Titular de la cuenta</label>
                                    <input name="titular_cuenta" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('titular_cuenta') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipo de cuenta</label>
                                    <select name="tipo_cuenta" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="Ahorros" @selected(old('tipo_cuenta')==='Ahorros')>Ahorros</option>
                                        <option value="Corriente" @selected(old('tipo_cuenta')==='Corriente')>Corriente</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de cuenta</label>
                                    <input name="numero_cuenta" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('numero_cuenta') }}">
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4"
                                 x-show="tipo !== 'renovacion' || cuentaActualizada" x-cloak>
                               
                            </div>
                        </div>

                                        {{-- Pregunta abierta --}}
<div class="rounded-md border border-gray-200 p-4">
    <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
        <span x-show="tipo == 'renovacion'" x-cloak>
            Recomendación para la fundación o sugerencia
        </span>

        <span x-show="tipo != 'renovacion'" x-cloak>
            Información adicional
        </span>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            <span x-show="tipo == 'renovacion'" x-cloak>
                Recomendación para la fundación o sugerencia
            </span>

            <span x-show="tipo != 'renovacion'" x-cloak>
                ¿Cómo encontró la Fundación Proseguir?
            </span>
        </label>

        <textarea
            name="como_encontro"
            rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            :placeholder="tipo == 'renovacion'
                ? 'Escribe una recomendación o sugerencia para la fundación...'
                : 'Cuéntanos brevemente cómo encontraste la fundación...'"
        >{{ old('como_encontro') }}</textarea>
    </div>
</div>

{{-- Promedio de carrera --}}
<div class="rounded-md border border-gray-200 p-4" x-show="tipo != 'renovacion'" x-cloak>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Promedio de carrera (0–5)
            </label>
            <input
                name="promedio_carrera"
                type="number"
                step="0.01"
                min="0"
                max="5"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                value="{{ old('promedio_carrera') }}"
            >
        </div>
    </div>
</div>
                    
                        {{-- Anexos --}}
<div class="rounded-md border border-gray-200 p-4">
    <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
        Anexos
    </div>

    {{-- Anexos para primera vez --}}
    <div x-show="tipo != 'renovacion'" x-cloak class="space-y-4">
        <p class="text-sm text-gray-700">
            Adjunta los documentos requeridos para la solicitud de beca por primera vez.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Documento de identidad (PDF/JPG)
                </label>
                <input
                    name="anexo_doc_identidad"
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Foto tipo documento (fondo blanco)
                </label>
                <input
                    name="anexo_foto_documento"
                    type="file"
                    accept=".jpg,.jpeg,.png,image/*"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
                <p class="mt-1 text-xs text-gray-500">
                    Esta foto la ve gerencia.
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Certificado cuenta bancaria (PDF/JPG)
                </label>
                <input
                    name="anexo_certificado_bancario"
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    PDF Notas
                </label>
                <input
                    name="pdf_notas"
                    type="file"
                    accept=".pdf,application/pdf"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    PDF Matrícula
                </label>
                <input
                    name="pdf_matricula"
                    type="file"
                    accept=".pdf,application/pdf"
                    class="mt-1 block w-full text-sm text-gray-700"
                >
            </div>
        </div>
    </div>

    {{-- Anexos para renovación --}}
<div x-show="tipo == 'renovacion'" x-cloak class="space-y-4">
    <p class="text-sm text-gray-700">
        Para renovación, adjunta el certificado de notas y el recibo de matrícula.
        Si actualizaste tu cuenta bancaria, marca la opción correspondiente y adjunta el certificado bancario.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Certificado de notas (PDF/JPG)
            </label>
            <input
                name="anexo_certificado_notas"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                class="mt-1 block w-full text-sm text-gray-700"
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Recibo de matrícula (PDF/JPG)
            </label>
            <input
                name="anexo_recibo_matricula"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                class="mt-1 block w-full text-sm text-gray-700"
            >
        </div>
    </div>

    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
        <label class="inline-flex items-center text-sm text-gray-700">
            <input
                type="checkbox"
                name="cuenta_actualizada"
                value="1"
                x-model="cuentaActualizada"
                class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
            >
            <span class="ms-2">Actualicé mis datos bancarios</span>
        </label>

        <div x-show="cuentaActualizada" x-cloak class="mt-4">
            <label class="block text-sm font-medium text-gray-700">
                Certificado cuenta bancaria (PDF/JPG)
            </label>
            <input
                name="anexo_certificado_bancario"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                class="mt-1 block w-full text-sm text-gray-700"
            >
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


    </div>

    @error('acepta_tratamiento_datos')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                        {{-- BOTONES --}}
                    <div class="flex justify-end gap-4 pt-4 border-t border-slate-200">
                        <a href="{{ route('student.postulaciones.index') }}"
                           class="px-6 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-black transition shadow-sm">
                            Crear postulación
                        </button>
                    </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
