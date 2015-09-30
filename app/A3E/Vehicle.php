<?php
namespace App\A3E;

class Vehicle extends Model
{
    protected $table = 'vehicle';

    public function owner()
    {
        return $this->belongstTo('App\A3E\Account', 'account_uid', 'uid');
    }
}