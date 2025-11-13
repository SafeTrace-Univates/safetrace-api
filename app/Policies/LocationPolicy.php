<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocationPolicy
{
    protected string $modelName;

    public function __construct()
    {
        $this->modelName = Location::class;
    }

    public function viewAny(User $user)
    {
        if($user->can(PermissionEnum::READ_LOCATION)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.default',
            ['model' => $this->modelName],
        ));
    }

    public function view(User $user, Location $location)
    {
        if ($user->can(PermissionEnum::READ_LOCATION) && $location->alert->ref_owner === $user->id) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.specific.m',
            ['model' => $this->modelName],
        ));
    }

    public function create(User $user)
    {
        if ($user->can(PermissionEnum::CREATE_LOCATION)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.create',
            ['model' => $this->modelName],
        ));
    }
}
