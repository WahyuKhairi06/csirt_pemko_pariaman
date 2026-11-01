<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, Setting $setting): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, Setting $setting): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, Setting $setting): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
