<?php
namespace App;

class Setting extends Model
{
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
