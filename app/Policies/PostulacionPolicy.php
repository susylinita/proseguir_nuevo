<?php

namespace App\Policies;

use App\Models\Postulacion;
use App\Models\User;

class PostulacionPolicy
{
    private function isPanelAdmin(User $user): bool
    {
        return ($user->is_admin ?? false) || $user->hasRole('admin_panel');
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
        return $this->isPanelAdmin($user);
    }

    public function delete(User $user, Postulacion $postulacion): bool
    {
        return $this->isPanelAdmin($user);
    }
}


