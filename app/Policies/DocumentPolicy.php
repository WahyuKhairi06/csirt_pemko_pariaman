<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator', 'analis'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, Document $document): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, Document $document): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
