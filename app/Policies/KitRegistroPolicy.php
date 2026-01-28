<?php

namespace App\Policies;

use App\Models\KitRegistro;
use App\Models\User;

class KitRegistroPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_admin
            || $user->hasRole(['coordinador', 'gerente']);
    }

    public function view(User $user, KitRegistro $registro): bool
    {
        return $user->is_admin
            || $user->hasRole(['coordinador', 'gerente']);
    }

    public function create(User $user): bool
    {
        return $user->is_admin
            || $user->hasRole(['coordinador', 'gerente']);
    }

    public function update(User $user, KitRegistro $registro): bool
    {
        return $user->is_admin
            || $user->hasRole(['coordinador', 'gerente']);
    }

    public function delete(User $user, KitRegistro $registro): bool
    {
        return $user->is_admin
            || $user->hasRole(['coordinador', 'gerente']);
    }
}
