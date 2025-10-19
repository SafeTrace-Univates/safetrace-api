<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use App\Traits\HasActiveRole;
use App\Traits\HasRoles;
use App\Traits\RoleAssignmentRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use RoleAssignmentRules;
    use HasActiveRole;
    use SoftDeletes;

    protected $table = 'users';

    protected $connection = ConnectionEnum::SAFETRACE;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'document',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getRolesListAttribute(): array
    {
        return $this->roles->pluck('name')->toArray();
    }

    public function getPermissionsListAttribute(): array
    {
        return $this->getAllPermissions()->pluck('name')->toArray();
    }
}
