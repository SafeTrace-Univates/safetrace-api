<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Recording;
use App\Models\User;
use Illuminate\Http\Response;

class RecordingPolicy
{


    public function viewAny(User $user)
    {
        if($user->can(PermissionEnum::READ_RECORDING)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.default',
            ['model' => Recording::class],
        ));
    }

    public function view(User $user, Recording $recording)
    {
        if($user->can(PermissionEnum::READ_RECORDING) && $recording->alert->ref_user === $user->id) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.specific.m',
            ['model' => Recording::class],
        ));
    }

    public function create(User $user)
    {
        if($user->can(PermissionEnum::CREATE_RECORDING)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.create',
            ['model' => Recording::class],
        ));
    }
}
