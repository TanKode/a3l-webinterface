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
        'confirmed',
        'confirmation_token',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'confirmation_token',
    ];

    protected $appends = [
        'role',
    ];

    protected $dontKeepRevisionOf = [
        'password',
    ];

    public static $rules = [
        'create' => [
            'name' => 'required|alpha_dash|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'player_id' => 'required|numeric|unique:users|exists:arma.players,pid',
            'password' => 'required|confirmed|min:6',
            'role' => 'array',
        ],
        'update' => [
            'name' => 'required|alpha_dash|max:255',
            'email' => 'required|email|max:255',
            'player_id' => 'required|numeric|exists:arma.players,pid',
            'password' => 'confirmed|min:6',
            'role' => 'array',
        ],
    ];

    public function player()
    {
        return $this->hasOne(Player::class, 'pid', 'player_id');
    }

    public function avatar($size = 64)
    {
        return 'https://gravatar.com/avatar/'.md5($this->email).'?d=mm&s='.$size;
    }

    public function hasPlayer()
    {
        return ! is_null($this->player);
    }

    public function getRoleAttribute()
    {
        return $this->roles()->lists('id')->toArray();
    }

    public function setRoleAttribute($value)
    {
        $this->roles()->sync($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public static function getList($remove = 0)
    {
        if (! is_array($remove)) {
            $remove = [$remove];
        }

        return self::whereNotIn('id', $remove)->lists('name', 'id');
    }

    public function scopeConfirmToken($query, $token)
    {
        $query->where('confirmation_token', $token);
    }

    public function scopeConfirmed($query)
    {
        $query->where('confirmed', 1);
    }

    public function scopeUnconfirmed($query)
    {
        $query->where('confirmed', 0);
    }

    public function sendVerificationEmail()
    {
        $user = $this;
        \Mail::send('emails.verification', [
            'user' => $user,
        ], function ($mail) use ($user) {
            $mail->from('noreply@gummibeer.de', trans('messages.title'));
            $mail->to($user->email, $user->name)->subject('E-Mail verification.');
        });
    }

    public function confirm()
    {
        return $this->update([
            'confirmed' => 1,
            'confirmation_token' => '',
        ]);
    }

    public function unconfirm()
    {
        $update = $this->update([
            'confirmed' => 0,
            'confirmation_token' => str_random(32),
        ]);
        if ($update) {
            $this->sendVerificationEmail();
        }

        return $update;
    }
}
