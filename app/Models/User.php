<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'tipo_documento',
        'cedula',
        'password',
        'portal',
        'is_admin',
        'becas_bloqueado',
        'becas_bloqueado_en',
        'becas_bloqueado_motivo',
        'becas_bloqueado_por',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'becas_bloqueado' => 'boolean',
        'becas_bloqueado_en' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return ($this->is_admin ?? false) || $this->hasAnyRole(['admin', 'admin_panel', 'coordinacion', 'gerencia']);
    }
}