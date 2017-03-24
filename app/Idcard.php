<?php
namespace App;

class Idcard extends Model
{
    protected $connection = 'arma';
    protected $table = 'perso';
    
    public $timestamps = false;

    protected $fillable = [
        'pid',
        'persoCop',
        'persoMed',
        'persoCiv',
        'persoEast',
    ];
    protected $hidden = [];

    public function player()
    {
        return $this->belongsTo(Player::class, 'pid', 'pid');
    }

    public function getPersoCopAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setPersoCopAttribute($value)
    {
        $this->attributes['persoCop'] = \Formatter::encodeDBArray($value);
    }

    public function getPersoMedAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setPersoMedAttribute($value)
    {
        $this->attributes['persoMed'] = \Formatter::encodeDBArray($value);
    }

    public function getPersoCivAttribute($value)
    {
        return \Formatter::decodeDBArray($value);
    }

    public function setPersoCivAttribute($value)
    {
        $this->attributes['persoCiv'] = \Formatter::encodeDBArray($value);
    }
}