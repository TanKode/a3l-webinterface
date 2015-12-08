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
    ];

    public function getDisplayNameAttribute()
    {
        return studly_case($this->attributes['name']);
    }
}
