<?php

namespace App\Traits;

use App\Models\UserActiveRole;

trait HasActiveRole
{
    protected $activeRole = null;

    public function setActiveRole(string $role)
    {
        UserActiveRole::updateOrCreate(
            ['user_id' => $this->id],
            ['role' => $role],
        );
    }

    public function unsetActiveRole()
    {
        UserActiveRole::where('user_id', $this->id)->delete();
    }

    public function getActiveRoleAttribute()
    {
        return $this->active_role_relation->role ?? $this->getStrongestRole();
    }

    public function active_role_relation()
    {
        return $this->hasOne(UserActiveRole::class, 'user_id');
    }
}
