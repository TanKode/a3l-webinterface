<?php

use Illuminate\Database\Migrations\Migration;

class GiveFuelLicense extends Migration
{
    public function up()
    {
        foreach (\App\User::with('player')->get() as $user) {
            if ($user->hasPlayer()) {
                $user->player->enableLicense('civ', 'license_civ_fuel');
            }
        }
    }

    public function down()
    {
        //
    }
}
