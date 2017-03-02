<?php

namespace App;

class Gang extends Model
{
    protected $connection = 'arma';
    protected $table = 'gangs';

    protected $fillable = [
        'name',
        'owner',
        'members',
        'maxmembers',
        'bank',
        'active',
    ];
    protected $hidden = [];

    public static $rules = [
        'update' => [
        ],
    ];

    public function owner()
    {
        return $this->belongsTo(Player::class, 'owner', 'pid');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
