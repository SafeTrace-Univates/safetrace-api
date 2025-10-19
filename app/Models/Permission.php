<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use App\Traits\LogsAll;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use LogsAll;

    protected $connection = ConnectionEnum::SAFETRACE;

    public $hidden = [
        'created_at',
        'updated_at',
    ];
}
