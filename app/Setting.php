<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $table = 'settings';
    protected $fillable = [
        'key',
        'value',
    ];

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = str_slug($value);
    }

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeKey($query, $key)
    {
        return $query->where('key', $key);
    }
}
