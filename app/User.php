<?php namespace A3LWebInterface;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, EntrustUserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'player_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public static $rules = array(
        'name' => 'required|alpha_dash|max:255|unique:users',
        'email' => 'required|email|max:255|unique:users',
        'player_id' => 'required|numeric|unique:users',
        'password' => 'required|confirmed|min:6'
    );

	public function player()
	{
		return $this->hasOne('A3LWebInterface\Player', 'playerid', 'player_id');
	}

	public function isAllowed($permission, $strict = false)
	{
		if(Auth::User()->hasRole('super_admin')) {
			return true;
		} elseif(Auth::User()->can($permission, $strict)) {
			return true;
		} else {
			return false;
		}
	}

}
