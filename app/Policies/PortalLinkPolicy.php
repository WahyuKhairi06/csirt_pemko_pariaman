<?php

namespace App\Policies;

use App\Models\PortalLink;
use App\Models\User;

class PortalLinkPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, PortalLink $portalLink): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, PortalLink $portalLink): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, PortalLink $portalLink): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
