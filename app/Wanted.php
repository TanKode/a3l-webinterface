<?php

namespace App;

class Wanted extends Model
{
    protected $connection = 'arma';
    protected $table = 'wanted';
    protected $primaryKey = 'wantedID';

    public $timestamps = false;

    protected $fillable = [
        'wantedID',
        'wantedName',
        'wantedCrimes',
        'wantedBounty',
        'active',
        'insert_time',
    ];
    protected $hidden = [];

    public function player()
    {
        return $this->hasOne(Player::class, 'pid', 'wantedID');
    }

    public function hasPlayer()
    {
        return ! is_null($this->player);
    }

    public function getWantedCrimesAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setWantedCrimesAttribute($value)
    {
        $this->attributes['wantedCrimes'] = \Formatter::encodeDBArray($value);
    }

    public function scopePid($query, $pid)
    {
        return $query->where('wantedID', $pid);
    }

    public function scopeActive($query, $active = 1)
    {
        return $query->where('active', $active);
    }
}
