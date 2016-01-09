<?php
namespace App;

class Vehicle extends Model
{
    protected $connection = 'arma';
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
    protected $hidden = [];

    protected $appends = [
        'display_name',
    ];

    public static $rules = [
        'update' => [
            'pid' => 'required|exists:arma.players,playerid',
            'classname' => 'required',
            'alive' => 'required|integer',
            'active' => 'required|integer',
        ],
    ];

    public function owner()
    {
        return $this->belongsTo(Player::class, 'pid', 'playerid');
    }

    public function getDisplayNameAttribute()
    {
        return transd('vehicles.'.$this->classname, $this->classname);
    }

    public function scopeAlive($query)
    {
        return $query->where('alive', 1);
    }
}
