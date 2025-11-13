<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AlertPolicy
{
    protected string $modelName;
    public function __construct()
    {
        $this->modelName = Alert::class;
    }

    public function viewAny(User $user)
    {
        if($user->can(PermissionEnum::READ_ALERT)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.default',
            ['model' => $this->modelName],
        ));
    }

    public function view(User $user, Alert $alert)
    {
        if($user->can(PermissionEnum::READ_ALERT) && $alert->ref_user === $user->id) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.specific.m',
            ['model' => $this->modelName],
        ));
    }

    public function create(User $user)
    {
        if($user->can(PermissionEnum::CREATE_ALERT)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.create',
            ['model' => $this->modelName],
        ));
    }

    public function update(User $user, Alert $alert)
    {
        if($user->can(PermissionEnum::UPDATE_ALERT) && $alert->ref_user === $user->id) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.update',
            ['model' => $this->modelName],
        ));
    }
}
