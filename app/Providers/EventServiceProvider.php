<?php
namespace App\Providers;

use App\Events\BackupCreated;
use App\Events\GangUpdated;
use App\Events\PermissionCreated;
use App\Events\PermissionUpdated;
use App\Events\PlayerUpdated;
use App\Events\RoleCreated;
use App\Events\RoleUpdated;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Events\VehicleDeleted;
use App\Events\VehicleUpdated;
use App\Listeners\EmailBackup;
use App\Listeners\EmailLogAction;
use App\Listeners\WebLogAction;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Vehicle
        VehicleUpdated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],
        VehicleDeleted::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],

        // Player
        PlayerUpdated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],

        // Gang
        GangUpdated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],

        // User
        UserCreated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],
        UserUpdated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],
        UserDeleted::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],

        // Role
        RoleCreated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],
        RoleUpdated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],

        // Permission
        PermissionCreated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],
        PermissionUpdated::class => [
            WebLogAction::class,
            EmailLogAction::class,
        ],

        // Backup
        BackupCreated::class => [
            EmailBackup::class,
        ],
    ];

    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}
