<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case READ_USER   = 'read_user';
    case ASSIGN_ROLE = 'assign_role';
    case REVOKE_ROLE = 'revoke_role';

    case ADD_CONTACT    = 'add_contact';
    case VIEW_CONTACTS  = 'view_contacts';
    case DELETE_CONTACT = 'delete_contact';
}
