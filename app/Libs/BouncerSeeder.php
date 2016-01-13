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
            'edit',
            'edit-civ',
            'edit-cop',
            'edit-medic',
            'edit-admin',
            'edit-money',
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
        ],
        ForumCategory::class => [
            'edit',
        ],
    ];

    public function seed()
    {
        foreach($this->models as $model => $abilities) {
            foreach($abilities as $ability) {
                \Bouncer::allow('super-admin')->to($ability, $model);
            }
        }
    }
}
