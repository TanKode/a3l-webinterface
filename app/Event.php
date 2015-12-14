<?php
namespace App;

use MaddHatter\LaravelFullcalendar\IdentifiableEvent;

class Event extends Model implements IdentifiableEvent
{
    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'starting_at',
        'ending_at',
        'url',
        'color',
    ];
    protected $hidden = [];

    protected $casts = [
        'id' => 'int',
    ];

    protected $dates = [
        'starting_at',
        'ending_at',
    ];

    public static $rules = [
        'create' => [
            'title' => 'required|max:255',
            'url' => 'url',
            'color' => 'required',
            'starting_at' => 'required|date',
            'ending_at' => 'required|date',
        ],
    ];

    public function getId()
    {
        return $this->getKey();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function isAllDay()
    {
        return true;
    }

    public function getStart()
    {
        return $this->starting_at;
    }

    public function getEnd()
    {
        return ($this->ending_at == $this->starting_at) ? $this->ending_at : $this->ending_at->addDay();
    }

    public function getEventOptions()
    {
        return [
            'url' => $this->url,
            'backgroundColor' => $this->color,
            'borderColor' => $this->color,
            'textColor' => \Helper::getContrastColor($this->color),
            'description' => \Markdown::text($this->description),
        ];
    }
}
