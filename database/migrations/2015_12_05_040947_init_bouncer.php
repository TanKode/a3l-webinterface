<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitBouncer extends Migration
{
    protected $abilities = [
        'view',
        'edit',
        'delete',
    ];

    protected $models = [
        \App\User::class,
        \App\Player::class,
        \App\Role::class,
        \App\Vehicle::class,
    ];

    public function up()
    {
        foreach($this->models as $model) {
            foreach($this->abilities as $ability) {
                Bouncer::allow('super-admin')->to($ability, $model);
            }
        }
    }

    public function down()
    {
        //
    }
}
