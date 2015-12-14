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

    public static $rules = [
        'create' => [
            'name' => 'required_without:display_name',
            'display_name' => 'required_without:name',
            'ability' => 'required|array',
        ],
        'update' => [
            'name' => 'required_without:display_name',
            'display_name' => 'required_without:name',
            'ability' => 'required|array',
        ],
    ];

    public function getDisplayNameAttribute()
    {
        return studly_case(array_get($this->attributes, 'name'));
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

    public static function getList()
    {
        return self::all()->pluck('display_name', 'id')->toArray();
    }
}
