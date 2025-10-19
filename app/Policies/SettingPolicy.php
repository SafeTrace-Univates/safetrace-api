<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SettingPolicy
{
    public function config(User $user)
    {
        if (!$user->hasRole(RoleEnum::ADMIN)) {
            return Response::deny(__(
                'policy.responses.deny.update',
                ['model' => 'Setting'],
            ));
        }

        return Response::allow();
    }
}
