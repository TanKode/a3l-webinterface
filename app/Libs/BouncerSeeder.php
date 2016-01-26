<?php
namespace App\Libs;

use App\Event;
use App\Player;
use App\Role;
use App\User;
use App\Vehicle;
use Riari\Forum\Models\Category as ForumCategory;

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
            'edit-admin',
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
    ];

    protected $abilities = [
        'view-backups',
        'download-backups',
        'delete-backups',
    ];

    public function seed()
    {
        foreach($this->models as $model => $abilities) {
            foreach($abilities as $ability) {
                \Bouncer::allow('superadmin')->to($ability, $model);
            }
        }

        foreach($this->abilities as $ability) {
            \Bouncer::allow('superadmin')->to($ability);
        }

        foreach(User::all() as $user) {
            $user->assign('member');
        }
    }
}
