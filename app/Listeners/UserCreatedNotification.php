<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Fenos\Notifynder\Builder\NotifynderBuilder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Silber\Bouncer\Database\Role;

class UserCreatedNotification
{
    public function __construct()
    {
    }

    public function handle(UserCreated $event)
    {
        $user = $event->user;
        \Notifynder::loop(Role::where('name', 'super-admin')->first()->users, function(NotifynderBuilder $builder, $to) use($user) {
            $builder->category('user.create')
                ->from($user->id)
                ->to($to->id)
                ->url('app/user');
        })->send();
    }
}
