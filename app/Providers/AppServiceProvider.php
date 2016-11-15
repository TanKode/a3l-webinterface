<?php

namespace App\Providers;

use App\Ability;
use App\Libs\BouncerSeeder;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Riari\Forum\Models\Category;

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