<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\System;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SystemPolicy
{
    public function viewAny(User $user)
    {
        if (!$user->hasRole(RoleEnum::ADMIN)) {
            return Response::deny(__(
                'policy.responses.deny.view.default',
                ['model' => 'System'],
            ));
        }

        return Response::allow();
    }

    public function view(User $user, System $system)
    {
        if (!$user->hasRole(RoleEnum::ADMIN)) {
            return Response::deny(__(
                'policy.responses.deny.view.default',
                ['model' => 'System'],
            ));
        }

        return Response::allow();
    }

    public function create(User $user)
    {
        if (!$user->hasRole(RoleEnum::ADMIN)) {
            return Response::deny(__(
                'policy.responses.deny.create',
                ['model' => 'System'],
            ));
        }

        return Response::allow();
    }

    public function delete(User $user, System $system)
    {
        if (!$user->hasRole(RoleEnum::ADMIN)) {
            return Response::deny(__(
                'policy.responses.deny.delete',
                ['model' => 'System'],
            ));
        }

        return Response::allow();
    }
}
