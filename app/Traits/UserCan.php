<?php
namespace App\Traits;

use App\A3L\Player as A3lPlayer;
use App\A3L\Vehicle as A3lVehicle;
use App\A3E\Account as A3eAccount;
use App\A3E\Player as A3ePlayer;
use App\A3E\Vehicle as A3eVehicle;
use App\A3E\Territory as A3eTerritory;
use App\Donation;
use App\Setting;
use App\User;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

trait UserCan
{
    protected $access = [
        'a3l' => [
            ['manage', A3lPlayer::class],
            ['manage', A3lVehicle::class],
        ],
        'a3e' => [
            ['manage', A3eAccount::class],
            ['manage', A3ePlayer::class],
            ['manage', A3eVehicle::class],
            ['manage', A3eTerritory::class],
        ],
        'administration' => [
            ['manage', User::class],
            ['manage', Role::class],
            ['manage', Ability::class],
            ['manage', Setting::class],
            ['manage', Donation::class],
        ],
        'access_management' => [
            ['manage', User::class],
            ['manage', Role::class],
            ['manage', Ability::class],
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