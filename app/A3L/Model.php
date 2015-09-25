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

    protected function getGearArray($value)
    {
        $data = $this->getArmaArray($value);
        dump($data);
        $gear = [
            'gear' => [
                'clothing' => $data[0],
                'backpack' => $data[2],
                'goggles' => $data[3],
                'hat' => $data[4],
                'map' => $data[5][0],
                'compass' => $data[5][1],
                'watch' => $data[5][2],
                'radio' => $data[5][3],
                'gps' => $data[5][4],
            ],
            'items' => $data[16],
        ];
        return $gear;
    }

    protected function setArmaArray(array $value)
    {
        return $value;
    }
}