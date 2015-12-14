<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasRolesAndAbilities, SoftDeletes;

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

    protected $appends = [
        'role',
    ];

    protected $dontKeepRevisionOf = [
        'password'
    ];

    public static $rules = [
        'create' => [
            'name' => 'required|alpha_dash|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'player_id' => 'required|numeric|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|array',
        ],
        'update' => [
            'name' => 'required|alpha_dash|max:255',
            'email' => 'required|email|max:255',
            'player_id' => 'required|numeric',
            'password' => 'confirmed|min:6',
            'role' => 'required|array',
        ],
    ];

    public function player()
    {
        return $this->hasOne(Player::class, 'playerid', 'player_id');
    }

    public function avatar($size = 64)
    {
        return 'https://gravatar.com/avatar/' . md5($this->email) . '?d=mm&s=' . $size;
    }

    public function hasPlayer()
    {
        return !is_null($this->player);
    }

    public function getRoleAttribute()
    {
        return $this->roles()->lists('id')->toArray();
    }

    public function setRoleAttribute($value)
    {
        $this->roles()->sync($value);
    }
}
