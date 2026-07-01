<div
    x-data="{ openContactModal: false }"
    style="font-family: Inter, Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;"
    class="rounded-[24px] border border-blue-200 bg-gradient-to-br from-white via-slate-50 to-blue-50 p-6 shadow-[0_14px_35px_rgba(15,23,42,0.06)]"
>
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

        {{-- Información --}}
        <div class="flex items-start gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-[18px] bg-blue-100 text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-7 w-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm3.75 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm3.75 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-3.92-.79L3 20l1.39-3.475A7.52 7.52 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>

            <div>
                <h3 class="text-lg font-extrabold tracking-tight text-slate-950">
                    ¿Necesitas ayuda?
                </h3>

                <p class="mt-2 max-w-4xl text-base font-medium leading-7 text-slate-600">
                    Si tienes dudas sobre tu postulación, renovación de beca, documentos requeridos
                    o el estado de tu solicitud, puedes comunicarte con la Fundación Proseguir por correo electrónico.
                </p>
            </div>
        </div>

        {{-- Acciones --}}
        <div class="flex flex-col gap-3 lg:shrink-0 sm:flex-row">
            <button
                type="button"
                x-on:click="openContactModal = true"
                class="inline-flex items-center justify-center rounded-[14px] border border-blue-200 bg-white px-5 py-3 text-base font-extrabold text-blue-700 shadow-sm transition hover:bg-blue-50"
            >
                Ver correo
            </button>
        </div>
    </div>

    {{-- Modal personalizado --}}
    <div
        x-show="openContactModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 px-4 backdrop-blur-sm"
    >
        <div
            x-on:click.outside="openContactModal = false"
            class="relative w-full max-w-md overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_24px_70px_rgba(15,23,42,0.25)]"
        >
            {{-- Fondo decorativo --}}
            <div class="absolute inset-0">
                <div class="h-full w-full bg-gradient-to-br from-white via-slate-50 to-blue-50"></div>
                <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-blue-200/50 blur-3xl"></div>
                <div class="absolute -bottom-16 -left-16 h-40 w-40 rounded-full bg-emerald-200/40 blur-3xl"></div>
                <div class="absolute left-0 right-0 top-0 h-1 bg-gradient-to-r from-blue-800 via-slate-900 to-emerald-500"></div>
            </div>

            <div class="relative p-7">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[20px] bg-blue-100 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-8 w-8"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0l-7.5-4.615A2.25 2.25 0 012.25 6.993V6.75" />
                    </svg>
                </div>

                <h3 class="mt-5 text-center text-2xl font-black tracking-tight text-slate-950">
                    Correo de contacto
                </h3>

                <p class="mt-2 text-center text-base leading-7 text-slate-600">
                    Copia este correo y úsalo en Gmail, Outlook o el correo de tu preferencia.
                </p>

                <div class="mt-5 rounded-2xl border border-blue-100 bg-white/80 p-4 text-center shadow-sm">
                    <p id="student-support-email" class="break-all text-lg font-black text-blue-800">
                        fundacion@grupoproseguir.com
                    </p>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <button
                        type="button"
                        x-on:click="
                            navigator.clipboard.writeText('correo@fundacionproseguir.org');
                            alert('Correo copiado: correo@fundacionproseguir.org');
                        "
                        class="inline-flex flex-1 items-center justify-center rounded-[14px] bg-blue-700 px-5 py-3 text-base font-extrabold text-white shadow-sm transition hover:bg-blue-800"
                    >
                        Copiar correo
                    </button>

                    <button
                        type="button"
                        x-on:click="openContactModal = false"
                        class="inline-flex flex-1 items-center justify-center rounded-[14px] border border-slate-300 bg-white px-5 py-3 text-base font-extrabold text-slate-700 shadow-sm transition hover:bg-slate-50"
                    >
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>