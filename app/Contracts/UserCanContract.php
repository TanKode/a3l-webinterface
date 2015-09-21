<?php
namespace App\Contracts;

use App\User;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

trait UserCanContract
{
    protected $access = [
        'administration' => [
            'manage', User::class,
            'manage', Role::class,
            'manage', Ability::class,
        ],
        'access_management' => [
            'manage', User::class,
            'manage', Role::class,
            'manage', Ability::class,
        ],
    ];

    public function cans(array $abilities, $strict = false)
    {
        if($strict) {
            foreach($abilities as $ability) {
                if (!$this->can(array_get($ability, 0), array_get($ability, 1))) {
                    return false;
                }
            }
            return true;
        } else {
            foreach($abilities as $ability) {
                if ($this->can(array_get($ability, 0), array_get($ability, 1))) {
                    return true;
                }
            }
            return false;
        }
    }

    public function canAccess($area)
    {
        $key = str_slug($area, '_');
        if(array_get($this->access, $key, false)) {
            return $this->cans(array_get($this->access, $key, false));
        } else {
            return false;
        }
    }
}