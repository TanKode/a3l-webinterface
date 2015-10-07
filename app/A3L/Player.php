<?php
namespace App\A3L;

use Carbon\Carbon;

class Player extends Model
{
    protected $primaryKey = 'uid';
    protected $table = 'players';
    protected $fillable = [
        'uid',
        'name',
        'playerid',
        'cash',
        'bankacc',
        'Karma',
        'civ_licenses',
        'civ_gear',
        'coplevel',
        'cop_licenses',
        'cop_gear',
        'mediclevel',
        'med_licenses',
        'med_gear',
        'adminlevel',
        'donatorlvl',
    ];

    protected $casts = [
        'cash' => 'int',
        'bankacc' => 'int',
        'Karma' => 'int',
        'coplevel' => 'int',
        'mediclevel' => 'int',
        'adminlevel' => 'int',
        'donatorlvl' => 'int',
    ];

    public function vehicles()
    {
        return $this->hasMany('App\A3L\Vehicle', 'pid', 'playerid');
    }

    public function civVehicles()
    {
        return $this->vehicles()->civ()->get();
    }

    public function copVehicles()
    {
        return $this->vehicles()->cop()->get();
    }

    public function medVehicles()
    {
        return $this->vehicles()->med()->get();
    }

    public function getNameAttribute($value)
    {
        return utf8_encode($value);
    }

    public function getCashMAttribute()
    {
        return format_money($this->cash);
    }

    public function getBankaccMAttribute()
    {
        return format_money($this->bankacc);
    }

    public function getCivLicensesAttribute($value)
    {
        return $this->getLicenseArray($value);
    }

    public function getCivGearAttribute($value)
    {
        return $this->getInventoryArray($value);
    }

    public function getCopLicensesAttribute($value)
    {
        return $this->getLicenseArray($value);
    }

    public function getCopGearAttribute($value)
    {
        return $this->getInventoryArray($value);
    }

    public function getMedLicensesAttribute($value)
    {
        return $this->getLicenseArray($value);
    }

    public function scopeUid($query, $uid)
    {
        return $query->where('uid', $uid);
    }

    public function scopePid($query, $pid)
    {
        return $query->where('playerid', $pid);
    }

    public function scopeLastDay($query)
    {
        $date = Carbon::now();
        $date->modify('- 24 hours');
        return $query->where('LastLogin', '>', $date);
    }
}