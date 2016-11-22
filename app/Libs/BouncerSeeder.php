<?php

namespace App\Libs;

use App\Event;
use App\Lotto;
use App\Player;
use App\Role;
use App\User;
use App\Vehicle;
use Riari\Forum\Models\Category as ForumCategory;
use Riari\Forum\Models\Thread as ForumThread;
use Riari\Forum\Models\Post as ForumPost;

class BouncerSeeder
{
    protected $models = [
        Event::class => [
            'edit',
            'delete',
        ],
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
            'edit-atac',
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
        ForumCategory::class => [
            'edit',
            'delete',
        ],
        ForumThread::class => [
            'edit',
            'delete',
        ],
        ForumPost::class => [
            'edit',
            'delete',
        ],
        Lotto::class => [
            'view',
        ],
    ];

    protected $abilities = [
        'view-backups',
        'download-backups',
        'delete-backups',
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

        foreach ($this->abilities as $ability) {
            \Bouncer::allow('superadmin')->to($ability);
        }

        foreach (User::with('player')->get() as $user) {
            $user->assign('member');
            if ($user->hasPlayer()) {
                $user->player->enableLicense('civ', 'license_civ_fuel');

                $user->retract('polizist');
                $user->retract('medic');
                $user->retract('atacler');
                if ($user->player->coplevel > 0) {
                    $user->assign('polizist');
                }
                if ($user->player->mediclevel > 0) {
                    $user->assign('medic');
                }
                if ($user->player->ataclevel > 0) {
                    $user->assign('atacler');
                }
            }
        }
    }
}
