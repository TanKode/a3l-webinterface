<?php

namespace App;

use Silber\Bouncer\Database\Ability as BouncerAbility;
use Venturecraft\Revisionable\RevisionableTrait;

class Ability extends BouncerAbility
{
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $appends = [
        'display_name',
    ];

    public static function getList()
    {
        return self::all()
            ->groupBy('entity_type')
            ->keyBy(function ($abilities) {
                return class_basename($abilities->first()->entity_type);
            })
            ->map(function ($ability) {
                return $ability->pluck('display_name', 'id');
            })
            ->toArray();
    }

    public function getDisplayNameAttribute()
    {
        $slug = strtolower($this->attributes['name']);
        if ($this->attributes['entity_type']) {
            $slug .= ' '.ucfirst(class_basename($this->attributes['entity_type']));
        }
        if ($this->attributes['entity_id']) {
            $slug .= '['.$this->attributes['entity_id'].']';
        }

        return $slug;
    }
}
