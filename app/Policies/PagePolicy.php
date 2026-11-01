<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    private array $allowedRoles = ['superadmin', 'koordinator', 'editor'];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function view(User $user, Page $page): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function update(User $user, Page $page): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }

    public function delete(User $user, Page $page): bool
    {
        // Beranda tidak boleh dihapus
        if ($page->is_home) {
            return false;
        }

        return $user->hasAnyRole($this->allowedRoles);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowedRoles);
    }
}
