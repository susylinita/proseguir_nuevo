<x-filament-panels::page.simple>
    <div class="fp-login-page">
        <div class="fp-login-card">
            <div class="fp-login-left">
                <div class="fp-login-badge">Panel Administrativo</div>

                <h1>Fundación Proseguir</h1>

                <p>
                    Gestiona postulaciones, becas, kits escolares, usuarios,
                    aprobaciones y reportes desde un solo lugar.
                </p>

                <ul>
                    <li>Control de postulaciones</li>
                    <li>Seguimiento por estados</li>
                    <li>Aprobación de gerencia</li>
                </ul>
            </div>

            <div class="fp-login-right">
                <div class="fp-login-logo">
                    <img src="{{ asset('images/logo-proseguir.png') }}" alt="Fundación Proseguir">
                </div>

                <h2>Acceso administrativo</h2>

                <p class="fp-login-subtitle">
                    Ingresa tus credenciales para continuar.
                </p>

                <x-filament-panels::form wire:submit="authenticate">
                    {{ $this->form }}

                    <x-filament-panels::form.actions
                        :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()"
                    />
                </x-filament-panels::form>
            </div>
        </div>
    </div>
</x-filament-panels::page.simple>