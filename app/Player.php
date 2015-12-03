<?php
namespace A3LWebInterface;

use A3LWebInterface\Libs\Formatter;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';
    protected $primaryKey = 'uid';

    protected $fillable = ['*'];
    protected $hidden = [''];

    protected $appends = [
        'total_money',
    ];

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
        return $this->hasMany(Vehicle::class, 'pid', 'playerid')->alive();
    }

    public function civVehicles()
    {
        return $this->vehicles()->civ();
    }

    public function copVehicles()
    {
        return $this->vehicles()->cop();
    }

    public function medVehicles()
    {
        return $this->vehicles()->med();
    }

    public function gang()
    {
        return Gang::where('members', 'LIKE', '%' . $this->attributes['playerid'] . '%')->first();
    }

    public function isGangOwner()
    {
        return (bool)($this->gang()->owner == $this->playerid);
    }

    public function getNameAttribute($value)
    {
        return utf8_encode($value);
    }

    public function getTotalMoneyAttribute()
    {
        return Formatter::money($this->cash + $this->bankacc);
    }
}
