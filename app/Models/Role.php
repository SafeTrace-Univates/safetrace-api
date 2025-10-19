<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use App\Traits\LogsAll;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use LogsAll;

    protected $connection = ConnectionEnum::SAFETRACE;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
