<?php

namespace App;

class Player extends Model
{
    protected $connection = 'arma';
    protected $table = 'players';
    protected $primaryKey = 'uid';

    public $timestamps = false;

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
        'donorlevel',
        'banking_pin',
    ];
    protected $hidden = [];

    protected $appends = [
        'alias',
        'total_money',
    ];

    protected $casts = [
        'uid' => 'int',
        'cash' => 'int',
        'bankacc' => 'int',
        'coplevel' => 'int',
        'mediclevel' => 'int',
        'adminlevel' => 'int',
        'donorlevel' => 'int',
    ];

    public static $rules = [
        'update' => [
            'cash' => 'integer',
            'bankacc' => 'integer',
            'coplevel' => 'integer',
            'mediclevel' => 'integer',
            'adminlevel' => 'integer',
            'banking_pin' => 'digits:4',
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pid', 'player_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'pid', 'pid');
    }

    public function hasUser()
    {
        return $this->user()->exists();
    }

    public function hasVehicles()
    {
        return $this->vehicles()->exists();
    }

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
        return is_array($this->aliases) ? array_get($this->aliases, 0, '') : '';
    }

    public function getTotalMoneyAttribute()
    {
        return $this->cash + $this->bankacc;
    }

    public function getCivLicensesAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setCivLicensesAttribute($value)
    {
        $this->attributes['civ_licenses'] = \Formatter::encodeDBArray($value);
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
        $this->attributes['cop_licenses'] = \Formatter::encodeDBArray($value);
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
        return $this->attributes['med_licenses'] = \Formatter::encodeDBArray($value);
    }

    public function getMedGearAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function getAtacLicensesAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setAtacLicensesAttribute($value)
    {
        return $this->attributes['atac_licenses'] = \Formatter::encodeDBArray($value);
    }

    public function getAtacGearAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function scopePid($query, $pid)
    {
        return $query->where('pid', $pid);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', 'LIKE', '%'.$name.'%');
    }

    public function scopeCop($query)
    {
        return $query->where('coplevel', '>', 0);
    }

    public function scopeMedic($query)
    {
        return $query->where('mediclevel', '>', 0);
    }

    public function enableLicense($area, $key)
    {
        $licences = [];
        foreach ($this->{$area.'_licenses'} as $index => $licence) {
            if ($licence[0] == $key) {
                $licences[$licence[0]] = 1;
            } else {
                $licences[$licence[0]] = $licence[1];
            }
        }
        $this->{$area.'_licenses'} = $licences;
        $this->save();
    }
}
