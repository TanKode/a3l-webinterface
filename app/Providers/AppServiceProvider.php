<?php

namespace App\Providers;

use App\Ability;
use App\Role;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Bouncer::useRoleModel(Role::class);
        \Bouncer::useAbilityModel(Ability::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}