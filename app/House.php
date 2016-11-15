<?php
namespace App;

class House extends Model
{
    protected $connection = 'arma';
    protected $table = 'houses';

    protected $fillable = [
        'pid',
        'pos',
        'owned',
        'inventory',
        'inventors',
    ];
    protected $hidden = [];

    public static $rules = [
        'update' => [
        ],
    ];

    public function owner()
    {
        return $this->belongsTo(Player::class, 'pid', 'playerid');
    }

    public function scopeOwned($query)
    {
        return $query->where('owned', 1);
    }
}
