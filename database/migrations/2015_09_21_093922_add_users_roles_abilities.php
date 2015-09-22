<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;

class AddUsersRolesAbilities extends Migration
{
    public function up()
    {
        \Bouncer::allow('super-admin');

        \Bouncer::allow('admin')->to('manage', User::class);
        \Bouncer::allow('admin')->to('manage', Role::class);
        \Bouncer::allow('admin')->to('manage', Ability::class);

        \Bouncer::allow('member');

        $gummibeer = User::create([
            'username' => 'gummibeer',
            'email' => 'dev.gummibeer@gmail.com',
            'password' => bcrypt(env('ADMIN_PASSWORD', 'Starten123')),
        ]);
        $gummibeer->assign('super-admin');
    }

    public function down()
    {
        //
    }
}
