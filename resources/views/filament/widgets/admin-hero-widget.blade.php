<div class="fp-admin-dashboard-header">
    <div class="fp-admin-dashboard-header__info">
        <div class="fp-admin-dashboard-header__badge">
            Panel Administrativo
        </div>

        <h1>
            Hola, {{ auth()->user()?->name ?? 'Administrador' }}
        </h1>

        <p>
            Revisa postulaciones en <strong>Postulado</strong>,
            <strong>En estudio</strong> y
            <strong>Pendiente aprobación gerencia</strong>,
            valida documentos, registra entrevistas y realiza seguimiento del proceso.
        </p>

        <small>
            {{ now()->timezone('America/Bogota')->format('Y-m-d H:i') }} · Fundación Proseguir
        </small>
    </div>

    <div class="fp-admin-dashboard-header__actions">
        <a href="{{ \App\Filament\Resources\PostulacionResource::getUrl('index') }}"
           class="fp-admin-dashboard-header__button fp-admin-dashboard-header__button--primary">
            Ver postulaciones
        </a>

        <a href="{{ request()->url() }}"
           class="fp-admin-dashboard-header__button fp-admin-dashboard-header__button--secondary">
            Refrescar dashboard
        </a>
    </div>
</div>