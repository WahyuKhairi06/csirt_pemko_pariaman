<?php

namespace App\Policies;

use App\Models\Advisory;
use App\Models\User;

class AdvisoryPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator', 'analis'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, Advisory $advisory): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, Advisory $advisory): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, Advisory $advisory): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
