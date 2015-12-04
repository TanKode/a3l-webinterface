<?php
namespace App\Events;

class RoleUpdated extends Event
{
    public function __construct($model, $comment)
    {
        $this->model = $model;
        $this->action = 'UPDATE';
        $this->comment = $comment;
    }
}
