<?php

namespace App\Policies;

use App\Models\Postulacion;
use App\Models\User;

class PostulacionPolicy
{
    private function isPanelAdmin(User $user): bool
    {
        return ($user->is_admin ?? false) || $user->hasRole('admin');
    }

    public function viewAny(User $user): bool
    {
        return $this->isPanelAdmin($user);
    }

    public function view(User $user, Postulacion $postulacion): bool
    {
        return $this->isPanelAdmin($user)
            || $postulacion->user_id === $user->id;
    }

    public function update(User $user, Postulacion $postulacion): bool
{
    // Admin puede siempre
    if ($this->isPanelAdmin($user)) {
        return true;
    }

    // Estudiante solo si es dueño y está pendiente
    return $postulacion->user_id === $user->id
        && $postulacion->estado === 'Pendiente';
}

    public function delete(User $user, Postulacion $postulacion): bool
    {
        return $this->isPanelAdmin($user);
    }
}


