<?php

namespace App\Teamspeak;

class Model
{
    protected $info;
    protected $attributes;

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        return array_get($this->attributes, $key);
    }
}
