<?php

namespace App\Services\Roles;

use App\Contracts\RoleSyncerContract;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Settings\Setting;
use Illuminate\Support\Collection;

class UserRoleSyncer implements RoleSyncerContract
{
    protected Setting $setting;

    public function __construct()
    {
        $this->setting = app(Setting::class);
    }

    public function roleName(): string
    {
        return RoleEnum::USER->value;
    }

    public function permissionNames(): array
    {
        return config('roles-permission')[$this->roleName()] ?? [];
    }

    public function ineligibleUsers(): Collection
    {
        return User::onlyTrashed()->get();
    }

    public function eligibleUsers(): Collection
    {
        return User::whereDoesntHave('roles')->get();
    }
}
