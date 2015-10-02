<?php
namespace App\A3L;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $connection = 'a3l';

    protected function getArmaArray($value)
    {
        return json_decode(str_replace('`', '"', substr($value, 1, -1)), true);
    }

    protected function getLicenseArray($value)
    {
        $data = $this->getArmaArray($value);
        $data = array_combine(array_column($data, 0), array_column($data, 1));
        return array_map(function($value) {
            return $value ? true : false;
        }, $data);
    }

    protected function getInventoryArray($value)
    {
        $data = $this->getArmaArray($value);
        if(is_array($data) && !empty($data)) {
            return array_count_values($data[16]);
        }
        return [];
    }

    protected function setArmaArray(array $value)
    {
        return $value;
    }
}