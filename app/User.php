<?php
namespace App;

use App\A3L\Player as A3lPlayer;
use App\A3E\Account as A3eAccount;
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
use Illuminate\Support\Collection;
use Riari\Forum\Models\Post;
use Riari\Forum\Models\Thread;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasRolesAndAbilities, Notifable, UserCan, AssignsRoles;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'signature',
        'facebook',
        'github',
        'steam',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'facebook',
        'github',
        'slack',
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

    public function threads()
    {
        return $this->hasMany(Thread::class, 'author_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function postedThreads()
    {
        $posts = $this->posts;
        $threads = new Collection();
        foreach($posts as $post) {
            $threads->put($post->thread->id, $post->thread);
        }
        return $threads;
    }

    public function a3lPlayer()
    {
        if(!is_null($this->steam)) {
            return A3lPlayer::pid($this->steam)->first();
        }
    }

    public function a3eAccount()
    {
        if(!is_null($this->steam)) {
            return A3eAccount::uid($this->steam)->first();
        }
    }

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

    public function addBambooCoins($amount)
    {
        $this->bamboo_coins += $amount;
        $this->save();
        $from = \Auth::check() ? \Auth::User()->id : 1;
        \Notifynder::category('coins.added')
            ->from($from)
            ->to($this->id)
            ->url('#')
            ->extra(['bamboo_amount' => $amount])
            ->send();
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

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
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

    public function scopeSteam($query, $id)
    {
        return $query->where('steam', $id);
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
