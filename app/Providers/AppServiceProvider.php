<?php

namespace App\Providers;

use App\Role;
use App\Ability;
use Carbon\Carbon;
use App\Libs\BouncerSeeder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Bouncer::seeder(BouncerSeeder::class);
        \Bouncer::useRoleModel(Role::class);
        \Bouncer::useAbilityModel(Ability::class);

        Carbon::setLocale(config('app.locale'));
    }

    public function register()
    {
        //
    }
}
