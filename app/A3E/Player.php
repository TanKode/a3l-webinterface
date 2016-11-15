<?php
namespace App\A3E;

class Player extends Model
{
    protected $table = 'player';

    protected $dates = [
        'spawned_at',
        'died_at',
    ];

    public function account()
    {
        return $this->belongstTo('App\A3E\Account', 'account_uid', 'uid');
    }

    public function scopeAlive($query)
    {
        return $query
            ->where('is_alive', 1)
            ->where('damage', '<>', 1)
            ->where('hitpoint_head', '<>', 1)
            ->where('hitpoint_body', '<>', 1)
            ->where('hitpoint_hands', '<>', 1)
            ->where('hitpoint_legs', '<>', 1);
    }
}