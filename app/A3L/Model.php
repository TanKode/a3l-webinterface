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
//        dump($data);
        $inventory = [];
        foreach($data[8] as $item) {
            $inventory[] = $item;
        }
        foreach($data[9] as $item) {
            $inventory[] = $item;
        }
        foreach($data[10] as $item) {
            $inventory[] = $item;
        }
        foreach($data[11] as $item) {
            $inventory[] = $item;
        }
        foreach($data[12] as $item) {
            $inventory[] = $item;
        }
        foreach($data[13] as $item) {
            $inventory[] = $item;
        }
        $gear = [
            'gear' => [
                'clothing' => $data[0],
                'vest' => $data[1],
                'backpack' => $data[2],
                'goggles' => $data[3],
                'hat' => $data[4],
                'additionals' => $data[5],
                'primary_weapon' => [
                    'type' => $data[6],
                    'additionals' => $data[14]
                ],
                'secondary_weapon' => [
                    'type' => $data[7],
                    'additionals' => $data[15]
                ],
                'inventory' => array_count_values($inventory),
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