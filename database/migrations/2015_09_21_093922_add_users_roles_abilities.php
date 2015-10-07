<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\A3L\Player as A3lPlayer;
use App\A3L\Vehicle as A3lVehicle;
use App\A3E\Account as A3eAccount;
use App\A3E\Player as A3ePlayer;
use App\A3E\Vehicle as A3eVehicle;
use App\A3E\Territory as A3eTerritory;
use App\User;
use Silber\Bouncer\Database\Role;
use Silber\Bouncer\Database\Ability;
use App\Setting;
use App\Donation;
use App\Changelog;
use App\Accounting;
use Riari\Forum\Models\Thread;
use Riari\Forum\Models\Post;

class AddUsersRolesAbilities extends Migration
{
    public function up()
    {
        \Bouncer::allow('super-admin');
        \Bouncer::allow('member');

        \Bouncer::allow('admin')->to('manage', A3lPlayer::class);
        \Bouncer::allow('admin')->to('manage', A3lVehicle::class);

        \Bouncer::allow('admin')->to('manage', A3eAccount::class);
        \Bouncer::allow('admin')->to('manage', A3ePlayer::class);
        \Bouncer::allow('admin')->to('manage', A3eVehicle::class);
        \Bouncer::allow('admin')->to('manage', A3eTerritory::class);

        \Bouncer::allow('admin')->to('manage', User::class);
        \Bouncer::allow('admin')->to('manage', Role::class);
        \Bouncer::allow('admin')->to('manage', Ability::class);
        \Bouncer::allow('admin')->to('manage', Setting::class);
        \Bouncer::allow('admin')->to('manage', Donation::class);
        \Bouncer::allow('admin')->to('manage', Changelog::class);
        \Bouncer::allow('admin')->to('manage', Accounting::class);

        \Bouncer::allow('admin')->to('lock', Thread::class);
        \Bouncer::allow('admin')->to('pin', Thread::class);
        \Bouncer::allow('admin')->to('delete', Thread::class);
        \Bouncer::allow('admin')->to('edit', Post::class);
        \Bouncer::allow('admin')->to('delete', Post::class);

        \Bouncer::allow('admin')->to('manage-admin-role');
        \Bouncer::allow('admin')->to('manage-member-role');

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
