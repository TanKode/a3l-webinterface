<?php
namespace App\A3E;

class Account extends Model
{
    protected $table = 'account';
    protected $fillable = [
        'uid',
        'name',
        'money',
        'score',
        'kills',
        'deaths',
    ];

    protected $casts = [
        'money' => 'float',
        'score' => 'int',
        'kills' => 'int',
        'deaths' => 'int',
    ];

    protected $dates = [
        'first_connect_at',
        'last_connect_at',
        'last_disconnect_at',
    ];

    public function players()
    {
        return $this->hasMany('App\A3E\Player', 'account_uid', 'uid');
    }

    public function curPlayer()
    {
        return $this->players()->alive();
    }

    public function territories()
    {
        return $this->hasMany('App\A3E\Territory', 'owner_uid', 'uid');
    }

    public function vehicles()
    {
        return $this->hasMany('App\A3E\Vehicle', 'account_uid', 'uid');
    }

    public function scopeUid($query, $uid)
    {
        return $query->where('uid', $uid);
    }
}