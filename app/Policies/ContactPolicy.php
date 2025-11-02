<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class ContactPolicy
{
    protected string $modelName;

    public function __construct()
    {
        $this->modelName = Contact::class;
    }

    public function viewAny(User $user)
    {
        if ($user->can(PermissionEnum::READ_CONTACT)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.default',
            ['model' => $this->modelName]
        ), );
    }

    public function view(User $user, Contact $contact)
    {
        if ($user->can(PermissionEnum::READ_CONTACT) && $contact->ref_owner === $user->id) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.view.specific.m',
            ['model' => $this->modelName]
        ));
    }

    public function create(User $user)
    {
        if ($user->can(PermissionEnum::CREATE_CONTACT)) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.create',
            ['model' => $this->modelName]
        ));
    }

    public function update(User $user, Contact $contact)
    {
        if ($user->can(PermissionEnum::UPDATE_CONTACT) && $contact->ref_owner === $user->id) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.update',
            ['model' => $this->modelName]
        ));
    }

    public function delete(User $user, Contact $contact)
    {
        if ($user->can(PermissionEnum::DELETE_CONTACT) && $contact->ref_owner === $user->id) {
            return Response::allow();
        }

        return Response::deny(__(
            'policy.responses.deny.delete',
            ['model' => $this->modelName]
        ));
    }
}
