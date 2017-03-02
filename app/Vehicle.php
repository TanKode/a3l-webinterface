<?php

namespace App;

class Vehicle extends Model
{
    protected $connection = 'arma';
    protected $table = 'vehicles';

    public $timestamps = false;

    protected $fillable = [
        'side',
        'classname',
        'type',
        'pid',
        'alive',
        'active',
        'plate',
        'color',
        'inventory',
        'insured',
        'insured_at',
    ];
    protected $hidden = [];

    protected $appends = [
        'display_name',
    ];

    public static $rules = [
        'update' => [
            'pid' => 'required|exists:arma.players,pid',
            'classname' => 'required',
            'alive' => 'required|integer',
            'active' => 'required|integer',
        ],
    ];

    public function owner()
    {
        return $this->belongsTo(Player::class, 'pid', 'pid');
    }

    public function getDisplayNameAttribute()
    {
        return transd('vehicles.'.$this->classname, $this->classname);
    }

    public function scopeAlive($query)
    {
        return $query->where('alive', 1);
    }

    public function scopeDestroyed($query)
    {
        return $query->where('alive', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', 0);
    }

    public function scopeInsured($query)
    {
        return $query->where('insured', 1);
    }

    public function scopeUninsured($query)
    {
        return $query->where('insured', 0);
    }

    public function scopePid($query, $pid)
    {
        return $query->where('pid', $pid);
    }

    public function scopeSearch($query, $string)
    {
        $search = collect(array_map('trim', explode(';', $string)))->map(function ($string) {
            return array_map('trim', explode('=', $string));
        })->pluck(1, 0);

        $searchable = [
            'pid' => 'LIKE',
            'side' => 'LIKE',
            'classname' => 'LIKE',
            'type' => 'LIKE',
            'alive' => '=',
            'active' => '=',
        ];

        foreach ($search as $key => $value) {
            $key = strtolower($key);
            if (array_key_exists($key, $searchable)) {
                $query->where($key, $searchable[$key], ($searchable[$key] == 'LIKE' ? '%'.$value.'%' : $value));
            }
        }

        return $query;
    }

    public function scopeCiv($query)
    {
        return $query->where('side', 'civ');
    }

    public function scopeCop($query)
    {
        return $query->where('side', 'cop');
    }

    public function scopeMedic($query)
    {
        return $query->where('side', 'med');
    }

    public function insure()
    {
        if (! $this->active) {
            return $this->update([
                'insured' => 1,
                'insured_at' => new \DateTime(),
            ]);
        }

        return false;
    }

    public function useInsurance()
    {
        $update = $this->update([
            'insured' => 0,
            'insured_at' => null,
            'alive' => 1,
            'active' => 0,
        ]);
        if ($this->owner->hasUser() && $update) {
            \Notify::category('vehicle.insurance')
                ->from(0)
                ->to($this->owner->user->getKey())
                ->url('#')
                ->extra([
                    'vehiclename' => $this->display_name,
                ])
                ->send();
        }

        return $update;
    }
}
