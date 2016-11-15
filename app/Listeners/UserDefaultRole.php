<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDefaultRole
{
    public function __construct()
    {
        //
    }

    public function handle(UserCreated $event)
    {
        $event->user->assign('member');
    }
}
