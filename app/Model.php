<?php
namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;

    public static function getSelectArray($key = 'id', $display = 'name')
    {
        return array_combine(self::orderBy('id')->lists($key)->toArray(), self::orderBy('id')->lists($display)->toArray());
    }
}