<?php
namespace App\A3E;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $connection = 'a3e';
    public $timestamps = false;

    protected function getArmaArray($value)
    {
        return json_decode(str_replace('`', '"', substr($value, 1, -1)), true);
    }

    protected function setArmaArray(array $value)
    {
        return $value;
    }
}