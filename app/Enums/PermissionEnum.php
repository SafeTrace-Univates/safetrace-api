<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case READ_USER   = 'read_user';
    case ASSIGN_ROLE = 'assign_role';
    case REVOKE_ROLE = 'revoke_role';

    case CREATE_CONTACT = 'create_contact';
    case READ_CONTACT   = 'read_contact';
    case DELETE_CONTACT = 'delete_contact';
    case UPDATE_CONTACT = 'update_contact';
}
