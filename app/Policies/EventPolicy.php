<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator', 'editor'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, Event $event): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, Event $event): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
