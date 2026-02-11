<?php

namespace App\Policies;

use App\Models\KitRegistro;
use App\Models\User;

class KitRegistroPolicy
{
    private function isPanelAdmin(User $user): bool
    {
        return ($user->hasRole('admin'));
    }

    public function viewAny(User $user): bool
    {
        return $this->isPanelAdmin($user);
    }

    public function view(User $user, $registro): bool
    {
        return $this->isPanelAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isPanelAdmin($user);
    }

    public function update(User $user, $registro): bool
    {
        return $this->isPanelAdmin($user);
    }

    public function delete(User $user, $registro): bool
    {
        return $this->isPanelAdmin($user);
    }
}

