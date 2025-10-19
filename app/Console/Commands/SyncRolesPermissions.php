<?php

namespace App\Console\Commands;

use App\Services\PermissionSyncer;
use App\Services\Roles\AdminRoleSyncer;
use App\Services\Roles\UserRoleSyncer;
use App\Services\RoleSyncerOrchestrator;
use Illuminate\Console\Command;

class SyncRolesPermissions extends Command
{
    protected $signature = 'permissions:sync';

    protected $description = 'Command description';

    private RoleSyncerOrchestrator $roleSyncerOrchestrator;
    private PermissionSyncer $permissionSyncer;

    public function __construct()
    {
        parent::__construct();

        $this->permissionSyncer = new PermissionSyncer();

        $this->roleSyncerOrchestrator = new RoleSyncerOrchestrator([
            new AdminRoleSyncer(),
            new UserRoleSyncer(),
        ]);
    }

    public function handle()
    {
        $this->info('Starting roles and permissions synchronization...');
        $startTime = microtime(true);

        try {
            $this->info('Syncing permissions...');
            $this->permissionSyncer->sync();
            $this->info('Syncing roles...');
            $this->roleSyncerOrchestrator->syncRoles();
        } catch (\Throwable $e) {
            $this->error('Error during synchronization: ' . $e->getMessage());
            return 1;
        }

        $endTime  = microtime(true);
        $duration = $endTime - $startTime;

        $seconds      = floor($duration);
        $milliseconds = round(($duration - $seconds) * 1000);

        $this->info("Sync duration: {$seconds}s {$milliseconds}ms. Roles and permissions synchronization completed successfully.");
    }
}
