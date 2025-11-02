<?php

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;

return [
    RoleEnum::ADMIN->value => [
        '*',
    ],
    RoleEnum::USER->value  => [
        PermissionEnum::READ_USER->value,
        PermissionEnum::CREATE_CONTACT->value,
        PermissionEnum::READ_CONTACT->value,
        PermissionEnum::DELETE_CONTACT->value,
        PermissionEnum::UPDATE_CONTACT->value,
    ],
];
