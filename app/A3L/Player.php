<?php
namespace App\A3L;

class Player extends Model
{
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
        return $this->getGearArray($value);
    }

    public function getCopLicensesAttribute($value)
    {
        return $this->getLicenseArray($value);
    }

    public function getMedLicensesAttribute($value)
    {
        return $this->getLicenseArray($value);
    }

    public function scopeUid($query, $uid)
    {
        return $query->where('uid', $uid);
    }
}