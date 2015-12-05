<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $connection = 'arma';
    protected $table = 'players';
    protected $primaryKey = 'uid';

    protected $fillable = [
        'cash',
        'bankacc',
        'civ_licenses',
        'civ_gear',
        'coplevel',
        'cop_licenses',
        'cop_gear',
        'mediclevel',
        'med_licenses',
        'med_gear',
        'adminlevel',
        'donatorlevel',
    ];
    protected $hidden = [];

    protected $appends = [
        'alias',
        'total_money',
    ];

    protected $casts = [
        'uid' => 'int',
        'cash' => 'int',
        'coplevel' => 'int',
        'bankacc' => 'int',
        'mediclevel' => 'int',
        'adminlevel' => 'int',
        'donatorlvl' => 'int',
    ];

    public function getNameAttribute($value)
    {
        return utf8_encode($value);
    }

    public function getAliasesAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function getAliasAttribute()
    {
        return $this->aliases[0];
    }

    public function getTotalMoneyAttribute()
    {
        return \Formatter::money($this->cash + $this->bankacc);
    }

    public function getCivLicensesAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setCivLicensesAttribute($value)
    {
        return \Formatter::encodeDBArray($value);
    }

    public function getCivGearAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function getCopLicensesAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setCopLicensesAttribute($value)
    {
        return \Formatter::encodeDBArray($value);
    }

    public function getCopGearAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function getMedLicensesAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setMedLicensesAttribute($value)
    {
        return \Formatter::encodeDBArray($value);
    }

    public function getMedGearAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }
}
