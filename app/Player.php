<?php
namespace App;

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
        'ataclevel',
        'atac_licenses',
        'atac_gear',
        'adminlevel',
        'donatorlvl',
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
        'donatorlvl' => 'int',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static $rules = [
        'update' => [
            'cash' => 'integer',
            'bankacc' => 'integer',
            'coplevel' => 'integer',
            'mediclevel' => 'integer',
            'ataclevel' => 'integer',
            'adminlevel' => 'integer',
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'playerid', 'player_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'pid', 'playerid');
    }

    public function messages()
    {
        return Message::where('fromID', $this->playerid)->orWhere('toID', $this->playerid)->orderBy('time', 'desc')->get();
    }

    public function skills()
    {
        return $this->hasOne(Skillsys::class, 'playerid', 'playerid');
    }

    public function messagesWithPlayer($player)
    {
        $playerId = $this->playerid;
        if ($player instanceof Player) $player = $player->playerid;
        return Message::where(function ($query) use ($playerId) {
            return $query->where('fromID', $playerId)->orWhere('toID', $playerId);
        })->where(function ($query) use ($player) {
            return $query->where('fromID', $player)->orWhere('toID', $player);
        })->orderBy('time', 'desc')->get();
    }

    public function getMessageParticipants()
    {
        $playerId = $this->playerid;
        return $this->messages()->map(function ($message) {
            return [
                'from' => $message->fromID,
                'to' => $message->toID,
            ];
        })->flatten()->toBase()->unique()->reject(function ($pid) use ($playerId) {
            return $pid == $playerId;
        })->map(function ($pid) {
            return Player::pid($pid)->first();
        })->filter();
    }

    public function hasUser()
    {
        return !is_null($this->user);
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
        return $query->where('playerid', $pid);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', 'LIKE', '%' . $name . '%');
    }

    public function scopeCop($query)
    {
        return $query->where('coplevel', '>', 0);
    }

    public function scopeMedic($query)
    {
        return $query->where('mediclevel', '>', 0);
    }

    public function scopeAtac($query)
    {
        return $query->where('ataclevel', '>', 0);
    }

    public function enableLicense($area, $key)
    {
        $licences = [];
        foreach($this->{$area.'_licenses'} as $index => $licence) {
            if($licence[0] == $key) {
                $licences[$licence[0]] = 1;
            } else {
                $licences[$licence[0]] = $licence[1];
            }
        }
        $this->{$area.'_licenses'} = $licences;
        $this->save();
    }
}
