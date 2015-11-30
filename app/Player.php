<?php namespace A3LWebInterface;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'players';
    protected $primaryKey = 'uid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [''];

    public static $rules = array(
        'name' => 'required|max:255',
        'playerid' => 'required|numeric',
        'cash' => 'required|numeric',
        'bankacc' => 'required|numeric',
        'cop_level' => 'numeric',
        'medic_level' => 'numeric',
    );

    public function vehicles()
    {
        return $this->hasMany('A3LWebInterface\Vehicle', 'pid', 'playerid')->where('alive', 1);
    }

    public function civVehicles()
    {
        return $this->hasMany('A3LWebInterface\Vehicle', 'pid', 'playerid')->where('alive', 1)->where('side', 'civ');
    }

    public function copVehicles()
    {
        return $this->hasMany('A3LWebInterface\Vehicle', 'pid', 'playerid')->where('alive', 1)->where('side', 'cop');
    }

    public function medVehicles()
    {
        return $this->hasMany('A3LWebInterface\Vehicle', 'pid', 'playerid')->where('alive', 1)->where('side', 'med');
    }

    public function gang()
    {
        return Gang::where('members', 'LIKE', '%' . $this->attributes['playerid'] . '%')->first();
    }

    public function isGangOwner()
    {
        return count(Gang::where('owner', $this->attributes['playerid'])->first()) > 0 ? true : false;
    }

    public function getNameAttribute($value)
    {
        return utf8_encode($value);
    }

}
