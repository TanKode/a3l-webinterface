<?php

namespace App;

class Skillsys extends Model
{
    protected $connection = 'arma';
    protected $table = 'skillsys';
    protected $primaryKey = 'playerid';

    protected $fillable = [
        'playerid',
    ];
    protected $hidden = [];

    public static $skills = [
        'nsa',
        'grab',
        'oil',
        'Moebel',
        'Wood',
        'Relikte',
        'Heroin',
        'Cocain',
        'Meth',
        'Iron',
        'Diamond',
        'Silber',
        'Cement',
        'Bronze',
        'marijuana',
        'Copper',
        'Erde',
        'Cobalt',
        'Sand',
        'Salt',
        'Raps',
        'Zink',
        'Fishing',
        'Fruit',
        'cop_time',
        'cop_action',
        'medic_time',
        'medic_action',
        'atac_time',
        'atac_action',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'playerid', 'playerid');
    }

    public function getFillable()
    {
        $fillables = parent::getFillable();
        foreach ($this::$skills as $skill) {
            $fillables[] = str_slug('skill_'.$skill, '_');
        }

        return $fillables;
    }
}
