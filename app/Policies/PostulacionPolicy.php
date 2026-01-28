<?php

namespace App\Policies;

use App\Models\Postulacion;
use App\Models\User;

class PostulacionPolicy
{
    public function viewAny(User $user): bool
    {
        return (bool) ($user->is_admin ?? false) || $user->hasRole(['coordinador', 'gerente']);
    }

    public function view(User $user, Postulacion $postulacion): bool
    {
        return (bool) ($user->is_admin ?? false)
            || $user->hasRole(['coordinador', 'gerente'])
            || $postulacion->user_id === $user->id;
    }

    public function update(User $user, Postulacion $postulacion): bool
    {
        return (bool) ($user->is_admin ?? false)
            || $user->hasRole(['coordinador', 'gerente']);
    }

    public function delete(User $user, Postulacion $postulacion): bool
    {
        return (bool) ($user->is_admin ?? false)
            || $user->hasRole(['coordinador', 'gerente']);
    }
}
