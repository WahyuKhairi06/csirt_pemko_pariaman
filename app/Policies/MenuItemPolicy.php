<?php

namespace App\Policies;

use App\Models\MenuItem;
use App\Models\User;

class MenuItemPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, MenuItem $menuItem): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, MenuItem $menuItem): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, MenuItem $menuItem): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
