<?php

namespace App\Providers;

use App\Player;
use App\Role;
use App\User;
use App\Vehicle;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->define('access-support', function ($user) {
            return $user->can('view-list', Player::class) || $user->can('view', Vehicle::class);
        });
        $gate->define('access-admin', function ($user) {
            return $user->can('view', User::class) || $user->can('view', Role::class) || $user->can('view-backups');
        });
    }
}
