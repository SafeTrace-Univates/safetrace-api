<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;

class ContactPolicy
{
    public function viewAny(User $user): bool
    {

    }   

    public function view(User $user): bool
    {
        return $user->can(PermissionEnum::READ_USER);
    }

    public function assignRole(User $user): bool
    {
        return $user->can(PermissionEnum::ASSIGN_ROLE);
    }

    public function revokeRole(User $user): bool
    {
        return $user->can(PermissionEnum::REVOKE_ROLE);
    }
}
