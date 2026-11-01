<?php

namespace App\Policies;

use App\Models\Agent;
use App\Models\User;

class AgentPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, Agent $agent): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, Agent $agent): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, Agent $agent): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
