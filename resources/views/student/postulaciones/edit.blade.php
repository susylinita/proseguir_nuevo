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
                    ✏️ Editando solicitud
                </div>

                {{-- Título --}}
                <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-slate-900">
                    Editar postulación #{{ $postulacion->id }}
                </h1>

                {{-- Descripción --}}
                <p class="mt-3 text-slate-700 max-w-2xl leading-relaxed">
                    Puedes modificar tu información mientras la postulación esté en estado
                    <span class="font-semibold">Pendiente</span>.
                </p>

                <p class="mt-3 text-sm text-slate-500">
                    Verifica cuidadosamente antes de guardar los cambios.
                </p>
            </div>

            {{-- Botones derecha --}}
            <div class="flex items-center gap-4">

                <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                   class="inline-flex items-center gap-2 
                          bg-white border border-slate-300 
                          text-slate-700 px-6 py-3 
                          rounded-xl font-medium 
                          hover:bg-slate-50 transition">
                    ← Volver al detalle
                </a>

                <a href="{{ route('student.postulaciones.index') }}"
                   class="inline-flex items-center gap-2 
                          bg-white border border-slate-300 
                          text-slate-700 px-6 py-3 
                          rounded-xl font-medium 
                          hover:bg-slate-50 transition">
                    Mis postulaciones
                </a>
    </div>
</x-slot>

<div class="max-w-5xl mx-auto py-10 px-6">
    

    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
            <div class="text-sm font-semibold text-red-800">Revisa los campos:</div>
            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="p-8 text-slate-900">

            <form method="POST"
                  action="{{ route('student.postulaciones.update', $postulacion) }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf
                @method('PUT')



    @php
        $tipo = old('tipo_postulacion', $postulacion->tipo_postulacion ?? 'primer_semestre');
        $cuentaActualizadaOld = old('cuenta_actualizada', $postulacion->cuenta_actualizada ? 1 : 0);
        $cuentaActualizadaChecked = (bool) $cuentaActualizadaOld;

        $fileUrl = fn(string $field) => route('student.postulaciones.file', [$postulacion, $field]);

        $badgeTipo = match ($tipo) {
            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
            'otro_semestre'   => 'Ingreso a otro semestre (primera vez)',
            'renovacion'      => 'Renovación (ya becado)',
            default           => 'N/D',
        };
    @endphp

    

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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"
                     x-data="{
                        tipo: '{{ $tipo }}',
                        cuentaActualizada: {{ $cuentaActualizadaChecked ? 'true' : 'false' }}
                     }">

                    <div class="mb-4 rounded-md bg-gray-50 p-4 text-sm text-gray-700">
                        Puedes actualizar tu información y adjuntar documentos mientras tu postulación esté en
                        <strong>Pendiente</strong>.
                    </div>

                    {{-- Datos del postulante (solo lectura) --}}
                    <div class="mb-6 rounded-md border border-gray-200 bg-gray-50 p-4 text-sm">
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
                          action="{{ route('student.postulaciones.update', $postulacion) }}"
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Tipo (solo lectura en edición) --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-2">Tipo de postulación</div>
                            <div class="text-sm font-medium text-gray-900">{{ $badgeTipo }}</div>
                            {{-- enviamos el tipo para que update pueda validar reglas por tipo --}}
                            <input type="hidden" name="tipo_postulacion" :value="tipo">
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
                                           value="{{ old('fecha_nacimiento', optional($postulacion->fecha_nacimiento)->format('Y-m-d')) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de documento</label>
                                    <input name="documento_identidad" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('documento_identidad', $postulacion->documento_identidad) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono celular</label>
                                    <input name="telefono_celular" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_celular', $postulacion->telefono_celular) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono fijo (opcional)</label>
                                    <input name="telefono_fijo" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_fijo', $postulacion->telefono_fijo) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dirección (opcional)</label>
                                    <input name="direccion" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('direccion', $postulacion->direccion) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Barrio</label>
                                    <input name="barrio" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('barrio', $postulacion->barrio) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Género</label>
                                    <select name="genero"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="F" @selected(old('genero', $postulacion->genero)==='F')>F</option>
                                        <option value="M" @selected(old('genero', $postulacion->genero)==='M')>M</option>
                                        <option value="Otro" @selected(old('genero', $postulacion->genero)==='Otro')>Otro</option>
                                        <option value="Prefiero no decir" @selected(old('genero', $postulacion->genero)==='Prefiero no decir')>Prefiero no decir</option>
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
                                           value="{{ old('nombre_acudiente', $postulacion->nombre_acudiente) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Teléfono acudiente</label>
                                    <input name="telefono_acudiente" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('telefono_acudiente', $postulacion->telefono_acudiente) }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Estudios --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Estudios
                            </div>

                            {{-- Primer semestre --}}
                            <div x-show="tipo === 'primer_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad a la que quiere aplicar</label>
                                        <input name="universidad_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_aplica', $postulacion->universidad_aplica) }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_aplica" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_aplica', $postulacion->carrera_aplica) }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Otro semestre --}}
                            <div x-show="tipo === 'otro_semestre'" x-cloak class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Universidad (opcional)</label>
                                        <input name="universidad_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('universidad_actual', $postulacion->universidad_actual) }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carrera (solo pregrado)</label>
                                        <input name="carrera_actual" type="text"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('carrera_actual', $postulacion->carrera_actual) }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Semestre en curso</label>
                                        <input name="semestre_en_curso" type="number" min="1" max="12"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                               value="{{ old('semestre_en_curso', $postulacion->semestre_en_curso) }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Renovación --}}
                            <div x-show="tipo === 'renovacion'" x-cloak class="space-y-4">
                                <p class="text-sm text-gray-700">
                                    Para renovación, sube únicamente: <strong>certificado de notas</strong> y <strong>recibo de matrícula</strong>.
                                    Si cambiaste la cuenta bancaria, actívalo y actualiza los datos.
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Certificado de notas (PDF/JPG)</label>
                                        <input name="anexo_certificado_notas" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                               class="mt-1 block w-full text-sm text-gray-700">
                                        @if ($postulacion->anexo_certificado_notas)
                                            <p class="mt-1 text-xs text-gray-500">
                                                Actual: <span class="font-medium">{{ basename($postulacion->anexo_certificado_notas) }}</span>
                                                · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_certificado_notas') }}" target="_blank" rel="noopener">Ver</a>
                                            </p>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Recibo matrícula (PDF/JPG)</label>
                                        <input name="anexo_recibo_matricula" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                               class="mt-1 block w-full text-sm text-gray-700">
                                        @if ($postulacion->anexo_recibo_matricula)
                                            <p class="mt-1 text-xs text-gray-500">
                                                Actual: <span class="font-medium">{{ basename($postulacion->anexo_recibo_matricula) }}</span>
                                                · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_recibo_matricula') }}" target="_blank" rel="noopener">Ver</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>

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
                                           value="{{ old('banco', $postulacion->banco) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Titular de la cuenta</label>
                                    <input name="titular_cuenta" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('titular_cuenta', $postulacion->titular_cuenta) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipo de cuenta</label>
                                    <select name="tipo_cuenta" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Selecciona…</option>
                                        <option value="Ahorros" @selected(old('tipo_cuenta', $postulacion->tipo_cuenta)==='Ahorros')>Ahorros</option>
                                        <option value="Corriente" @selected(old('tipo_cuenta', $postulacion->tipo_cuenta)==='Corriente')>Corriente</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Número de cuenta</label>
                                    <input name="numero_cuenta" type="text"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('numero_cuenta', $postulacion->numero_cuenta) }}">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Certificado cuenta (PDF/JPG)</label>
                                <input name="anexo_certificado_bancario" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                       class="mt-1 block w-full text-sm text-gray-700"
                                       :disabled="(tipo === 'renovacion' && !cuentaActualizada)">
                                @if ($postulacion->anexo_certificado_bancario)
                                    <p class="mt-1 text-xs text-gray-500">
                                        Actual: <span class="font-medium">{{ basename($postulacion->anexo_certificado_bancario) }}</span>
                                        · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_certificado_bancario') }}" target="_blank" rel="noopener">Ver</a>
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Anexos (primera vez) --}}
                        <div class="rounded-md border border-gray-200 p-4"
                             x-show="tipo !== 'renovacion'" x-cloak>
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Anexos (primera vez)
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Documento de identidad (PDF/JPG)</label>
                                    <input name="anexo_doc_identidad" type="file" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/*"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    @if ($postulacion->anexo_doc_identidad)
                                        <p class="mt-1 text-xs text-gray-500">
                                            Actual: <span class="font-medium">{{ basename($postulacion->anexo_doc_identidad) }}</span>
                                            · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_doc_identidad') }}" target="_blank" rel="noopener">Ver</a>
                                        </p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Foto tipo documento (fondo blanco)</label>
                                    <input name="anexo_foto_documento" type="file" accept=".jpg,.jpeg,.png,image/*"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    <p class="mt-1 text-xs text-gray-500">Esta foto la ve gerencia.</p>

                                    @if ($postulacion->anexo_foto_documento)
                                        <div class="mt-2 flex items-start gap-3">
                                            <img
                                                src="{{ $fileUrl('anexo_foto_documento') }}"
                                                alt="Foto actual"
                                                class="w-20 h-auto rounded-md border border-gray-300"
                                            >
                                            <div class="text-xs text-gray-500">
                                                Actual: <span class="font-medium">{{ basename($postulacion->anexo_foto_documento) }}</span>
                                                <div>
                                                    <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('anexo_foto_documento') }}" target="_blank" rel="noopener">Ver</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Promedio de carrera (0–5)
                                    </label>
                                    <input name="promedio_carrera" type="number" step="0.01" min="0" max="5"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('promedio_carrera', $postulacion->promedio_carrera) }}">
                                </div>
                            </div>
                        </div>

                        {{-- Puntajes (existentes) --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Puntajes
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="puntaje_saber">
                                        Puntaje Saber (mín. 300)
                                    </label>
                                    <input id="puntaje_saber" name="puntaje_saber" type="number" step="0.01" min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('puntaje_saber', $postulacion->puntaje_saber) }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="promedio_universitario">
                                        Promedio universitario (mín. 3.8)
                                    </label>
                                    <input id="promedio_universitario" name="promedio_universitario" type="number" step="0.01" min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('promedio_universitario', $postulacion->promedio_universitario) }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Información adicional (de último) --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Información adicional
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    ¿Cómo encontraron la Fundación Proseguir?
                                </label>
                                <textarea name="como_encontro" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                          placeholder="Cuéntanos brevemente...">{{ old('como_encontro', $postulacion->como_encontro) }}</textarea>
                            </div>
                        </div>

                        {{-- PDFs antiguos (si los sigues usando) --}}
                        <div class="rounded-md border border-gray-200 p-4">
                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-3">
                                Documentos académicos
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="pdf_notas">
                                        PDF Notas
                                    </label>
                                    <input id="pdf_notas" name="pdf_notas" type="file" accept=".pdf,application/pdf"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    @if ($postulacion->pdf_notas)
                                        <p class="mt-1 text-xs text-gray-500">
                                            Actual: <span class="font-medium">{{ basename($postulacion->pdf_notas) }}</span>
                                            · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('pdf_notas') }}" target="_blank" rel="noopener">Ver</a>
                                        </p>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="pdf_matricula">
                                        PDF Matrícula
                                    </label>
                                    <input id="pdf_matricula" name="pdf_matricula" type="file" accept=".pdf,application/pdf"
                                           class="mt-1 block w-full text-sm text-gray-700">
                                    @if ($postulacion->pdf_matricula)
                                        <p class="mt-1 text-xs text-gray-500">
                                            Actual: <span class="font-medium">{{ basename($postulacion->pdf_matricula) }}</span>
                                            · <a class="text-indigo-600 hover:text-indigo-900" href="{{ $fileUrl('pdf_matricula') }}" target="_blank" rel="noopener">Ver</a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a href="{{ route('student.postulaciones.show', $postulacion) }}"
                             class="px-6 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                                Cancelar
                            </a>

                            <button type="submit"
                              class="px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-black transition shadow-sm">
                                Guardar cambios
                            </button>

                    </form>

                </div>
            </div>


</x-app-layout>
