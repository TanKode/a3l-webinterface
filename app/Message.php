<?php
namespace App;

class Message extends Model
{
    protected $connection = 'arma';
    protected $table = 'messages';
    protected $primaryKey = 'uid';
    public $timestamps = false;

    protected $fillable = [];
    protected $hidden = [];

    protected $dates = [
        'time',
    ];

    public function sender()
    {
        return $this->belongsTo(Player::class, 'fromID', 'playerid');
    }

    public function receiver()
    {
        return $this->belongsTo(Player::class, 'toID', 'playerid');
    }

    public function getMessageAttribute($value)
    {
        return utf8_encode(trim($value, '"'));
    }
}
