<?php

namespace App;

use App\Contracts\UserCanContract;
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
    use Authenticatable, Authorizable, CanResetPassword, HasRolesAndAbilities, UserCanContract;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'facebook',
        'github',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'facebook',
        'github',
    ];

    public static $rules = [
        'create' => [
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'confirmed|min:8',
        ],
        'update' => [
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'confirmed|min:8',
        ],
    ];

    public function avatar($size = 64)
    {
        if(!empty($this->facebook_id)) {
            return 'https://graph.facebook.com/v2.4/' . $this->facebook_id . '/picture?type=normal';
        } else {
            return 'https://gravatar.com/avatar/'.md5($this->email).'?d=mm&s='.$size;
        }
    }

    public function isSuperAdmin()
    {
        return $this->is('super-admin');
    }

    public function saveOauthId($provider, $id)
    {
        $this->$provider = $id;
        $this->save();
    }

    public function scopeFacebook($query, $id)
    {
        return $query->where('facebook', $id);
    }

    public function scopeGithub($query, $id)
    {
        return $query->where('github', $id);
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
