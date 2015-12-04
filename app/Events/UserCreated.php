<?php
namespace App\Events;

class UserCreated extends Event
{
    public function __construct($model, $comment)
    {
        $this->model = $model;
        $this->action = 'CREATE';
        $this->comment = $comment;
    }
}
