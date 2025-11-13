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

    case CREATE_ALERT = 'create_alert';
    case READ_ALERT   = 'read_alert';
    case UPDATE_ALERT = 'update_alert';

    case CREATE_LOCATION = 'create_location';
    case READ_LOCATION   = 'read_location';

    case CREATE_RECORDING = 'create_recording';
    case READ_RECORDING   = 'read_recording';
}
