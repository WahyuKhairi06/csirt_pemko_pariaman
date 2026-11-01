<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator', 'editor'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, Post $post): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, Post $post): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
