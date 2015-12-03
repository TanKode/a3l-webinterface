<?php namespace A3LWebInterface;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = ['*'];
    protected $hidden = [''];

    protected $appends = [
        'display_name',
    ];

    public static $rules = array(
        'side' => 'required',
        'classname' => 'required',
        'type' => 'required',
        'pid' => 'required|numeric',
        'color' => 'required|numeric',
        'plate' => 'required|numeric',
    );

    public function owner()
    {
        return $this->hasOne('A3LWebInterface\Player', 'playerid', 'pid');
    }

    public function getDisplayNameAttribute()
    {
        return transd('vehicles.' . $this->classname);
    }

    public function scopeAlive($query)
    {
        return $query->where('alive', 1);
    }

    public function scopeCiv($query)
    {
        return $query->where('side', 'civ');
    }

    public function scopeCop($query)
    {
        return $query->where('side', 'cop');
    }

    public function scopeMed($query)
    {
        return $query->where('side', 'med');
    }
}
