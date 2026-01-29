<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    /**
     * Título de la página
     */
    public function getHeading(): string | Htmlable
    {
        return 'Acceso administrativo';
    }

    /**
     * Descripción debajo del título
     */
    public function getSubheading(): string | Htmlable | null
    {
        return 'Inicia sesión para gestionar postulaciones, kits, aprobaciones y reportes.';
    }
}
