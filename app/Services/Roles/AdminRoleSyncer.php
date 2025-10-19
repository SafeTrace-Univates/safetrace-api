<?php

namespace App\Services\Roles;

use App\Contracts\RoleSyncerContract;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Settings\Setting;
use Illuminate\Support\Collection;

class AdminRoleSyncer implements RoleSyncerContract
{
    protected Setting $setting;

    public function __construct()
    {
        $this->setting = app(Setting::class);
    }

    public function roleName(): string
    {
        return RoleEnum::ADMIN->value;
    }

    public function permissionNames(): array
    {
        return ['*'];
    }

    public function ineligibleUsers(): Collection
    {
        return User::whereNotIn('id', $this->setting->admin_users)
            ->whereHas('roles', function ($subquery) {
                $subquery->where('name', $this->roleName());
            })
            ->get();
    }

    public function eligibleUsers(): Collection
    {
        return User::whereIn('id', $this->setting->admin_users)
            ->where(function ($query) {
                $query->whereHas('roles', function ($subquery) {
                    $subquery->whereNot('name', $this->roleName());
                })->orWhereDoesntHave('roles');
            })
            ->get() ?? collect();
    }
}
