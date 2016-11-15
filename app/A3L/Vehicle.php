<?php
namespace App\A3L;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $fillable = [
        'side',
        'classname',
        'type',
        'pid',
        'alive',
        'active',
        'plate',
        'color',
        'inventory',
    ];

    protected $casts = [
        'alive' => 'bool',
        'active' => 'bool',
        'color' => 'int',
    ];

    public function owner()
    {
        return $this->belongsTo('App\A3L\Player', 'pid', 'playerid');
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

    public function scopeCar($query)
    {
        return $query->where('type', 'Car');
    }

    public function scopeAir($query)
    {
        return $query->where('type', 'Air');
    }

    public function scopeAlive($query)
    {
        return $query->where('alive', 1);
    }
}