<?php
namespace App;

class Changelog extends Model
{
    protected $table = 'changelogs';
    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'content',
    ];
    protected $hidden = [];

    public static $rules = [
        'create' => [
            'title' => 'required|string|unique:changelogs',
            'slug' => 'required|alpha_dash|unique:changelogs',
            'content' => 'required|string',
        ],
        'update' => [
            'title' => 'required|string',
            'slug' => 'required|alpha_dash',
            'content' => 'required|string',
        ],
    ];

    public function getAuthorAttribute()
    {
        return User::withTrashed()->find($this->author_id);
    }

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
