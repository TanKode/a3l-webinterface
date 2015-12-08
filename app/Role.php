<?php
namespace App;

use Silber\Bouncer\Database\Role as BouncerRole;
use Venturecraft\Revisionable\RevisionableTrait;

class Role extends BouncerRole
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $appends = [
        'display_name',
        'ability',
    ];

    public function getDisplayNameAttribute()
    {
        return studly_case($this->attributes['name']);
    }

    public function setDisplayNameAttribute($value)
    {
        $this->name = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_slug($value);
    }

    public function getAbilityAttribute()
    {
        return $this->abilities()->lists('id')->toArray();
    }

    public function setAbilityAttribute($value)
    {
        $this->abilities()->sync($value);
    }
}
