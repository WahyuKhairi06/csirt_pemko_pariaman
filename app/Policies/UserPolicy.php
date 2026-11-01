<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    private array $allowedRoles = ['superadmin'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, User $model): bool
    {
        // Jangan biarkan superadmin menghapus dirinya sendiri
        if ($user->id === $model->id) {
            return false;
        }

        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
