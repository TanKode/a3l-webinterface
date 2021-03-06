<?php

namespace App\Libs;

use App\Role;
use App\User;
use App\Player;
use App\Vehicle;

class BouncerSeeder
{
    protected $models = [
        User::class => [
            'view',
            'edit',
            'delete',
        ],
        Player::class => [
            'view',
            'view-list',
            'edit',
            'edit-money',
            'edit-civ',
            'edit-cop',
            'edit-medic',
            'edit-admin',
            'edit-donator',
            'delete',
        ],
        Vehicle::class => [
            'view',
            'edit',
            'delete',
        ],
        Role::class => [
            'view',
            'edit',
            'delete',
        ],
    ];

    public function seed()
    {
        \Log::debug('seed bouncer with default data & force assignments', [
            'component' => 'artisan.command',
            'class' => get_called_class(),
            'signature' => 'bouncer:seed',
        ]);
        foreach ($this->models as $model => $abilities) {
            foreach ($abilities as $ability) {
                \Bouncer::allow('superadmin')->to($ability, $model);
            }
        }

        foreach (User::with('player')->get() as $user) {
            if ($user->hasPlayer()) {
                $user->assign('member');
                $user->retract('cop');
                $user->retract('medic');
                if ($user->player->coplevel > 0) {
                    $user->assign('cop');
                }
                if ($user->player->mediclevel > 0) {
                    $user->assign('medic');
                }
            }
        }
    }
}
