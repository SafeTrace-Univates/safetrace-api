<?php

namespace App\Services;

use App\Contracts\RoleSyncerContract;
use App\Models\Permission;
use App\Models\Role;

class RoleSyncerOrchestrator
{
    /**
     * @var RoleSyncerContract[]
     */
    protected $syncers;

    public function __construct(array $syncers)
    {
        $this->syncers = $syncers;
    }

    public static function make(array $syncers): self
    {
        return new self($syncers);
    }

    public function syncRoles(): void
    {
        foreach ($this->syncers as $syncer) {
            $role = Role::firstOrCreate([
                'name' => $syncer->roleName(),
            ]);

            $names = $syncer->permissionNames();

            if (in_array('*', $names, true)) {
                $role->syncPermissions(Permission::all());
            } else {
                $valid = collect($names)->filter(fn ($name) => Permission::where('name', $name)->exists())->all();
                $role->syncPermissions($valid);
            }

            $syncer->eligibleUsers()->each(function ($user) use ($role, $syncer) {
                if (! $user->hasRole($role->name)) {
                    $user->assignRole($role->name);
                }
            });

            $syncer->ineligibleUsers()->each(function ($user) use ($role) {
                if ($user->hasRole($role->name)) {
                    $user->removeRole($role->name);
                }
            });
        }
    }
}
