<?php

namespace App;

class House extends Model
{
    protected $connection = 'arma';
    protected $table = 'houses';

    public $timestamps = false;

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
        return $this->belongsTo(Player::class, 'pid', 'pid');
    }

    public function scopeOwned($query)
    {
        return $query->where('owned', 1);
    }
}
