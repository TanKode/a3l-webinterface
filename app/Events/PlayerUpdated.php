<?php
namespace App\Events;

class PlayerUpdated extends Event
{
    public function __construct($model, $comment)
    {
        $this->model = $model;
        $this->action = 'UPDATE';
        $this->comment = $comment;
    }
}
