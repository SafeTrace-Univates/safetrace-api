<?php

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;

return [
    RoleEnum::ADMIN->value => [
        '*',
    ],
    RoleEnum::USER->value  => [
        PermissionEnum::READ_USER->value,
        PermissionEnum::ADD_CONTACT->value,
        PermissionEnum::VIEW_CONTACTS->value,
        PermissionEnum::DELETE_CONTACT->value,
    ],
];
