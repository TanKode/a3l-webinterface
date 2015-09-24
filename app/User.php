<?php
namespace App;

use App\Traits\AssignsRoles;
use App\Traits\UserCan;
use Fenos\Notifynder\Notifable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Silber\Bouncer\Database\Role;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasRolesAndAbilities, Notifable, UserCan, AssignsRoles;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'facebook',
        'github',
        'steam',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'facebook',
        'github',
        'steam',
    ];

    public static $rules = [
        'create' => [
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'confirmed|min:8',
        ],
        'update' => [
            'email' => 'required|email',
            'password' => 'confirmed|min:8',
        ],
    ];

    public function can($ability, $arguments = [])
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        if(is_subclass_of($arguments, EloquentModel::class)) {
            $model = new $arguments();
            $ability = Ability::where('name', $ability)->forModel($model)->first();
        } else {
            $ability = Ability::where('name', $ability)->simpleAbility()->first();
        }
        if(!is_null($ability)) {
            return $this->role->abilities->contains(function ($key, $value) use ($ability) {
                return $value->id == $ability->id;
            });
        } else {
            return false;
        }
    }

    public function avatar($size = 64)
    {
        if(!empty($this->facebook_id)) {
            return 'https://graph.facebook.com/v2.4/' . $this->facebook_id . '/picture?type=normal';
        } else {
            return 'https://gravatar.com/avatar/'.md5($this->email).'?d=mm&s='.$size;
        }
    }

    public function getRoleAttribute()
    {
        return $this->roles->first();
    }

    public function setRoleIdAttribute($value)
    {
        $role = $this->getRoleName($value * 1);
        if(isset($role)) {
            $this->retractAll();
            $this->assign($role);
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

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeFacebook($query, $id)
    {
        return $query->where('facebook', $id);
    }

    public function scopeGithub($query, $id)
    {
        return $query->where('github', $id);
    }

    public function scopeSlack($query, $id)
    {
        return $query->where('slack', $id);
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
