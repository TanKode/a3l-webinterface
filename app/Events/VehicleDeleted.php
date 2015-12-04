<?php
namespace App\Events;

class VehicleDeleted extends Event
{
    public function __construct($model, $comment)
    {
        $this->model = $model;
        $this->action = 'DELETE';
        $this->comment = $comment;
    }
}
