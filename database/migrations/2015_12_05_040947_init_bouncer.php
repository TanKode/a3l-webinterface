<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitBouncer extends Migration
{
    public function up()
    {
        Bouncer::allow('super-admin')->to('view', \App\User::class);
        Bouncer::allow('super-admin')->to('edit', \App\User::class);
        Bouncer::allow('super-admin')->to('delete', \App\User::class);
    }

    public function down()
    {
        //
    }
}
