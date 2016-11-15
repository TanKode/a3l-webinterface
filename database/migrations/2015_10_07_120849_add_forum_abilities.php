<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Riari\Forum\Models\Thread;
use Riari\Forum\Models\Post;

class AddForumAbilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Bouncer::allow('admin')->to('lock', Thread::class);
        \Bouncer::allow('admin')->to('pin', Thread::class);
        \Bouncer::allow('admin')->to('delete', Thread::class);
        \Bouncer::allow('admin')->to('edit', Post::class);
        \Bouncer::allow('admin')->to('delete', Post::class);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
