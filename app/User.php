<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasRolesAndAbilities;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'player_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static $rules = [
        'name' => 'required|alpha_dash|max:255|unique:users',
        'email' => 'required|email|max:255|unique:users',
        'player_id' => 'required|numeric|unique:users',
        'password' => 'required|confirmed|min:6'
    ];

    public function player()
    {
        return $this->hasOne(Player::class, 'playerid', 'player_id');
    }

    public function avatar($size = 64)
    {
        return 'https://gravatar.com/avatar/' . md5($this->email) . '?d=mm&s=' . $size;
    }
}
