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
}