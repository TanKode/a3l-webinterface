<?php
namespace App\Events;

class LoggableActionDone extends Event
{
    public function __construct($model, $action, $comment)
    {
        $this->model = $model;
        $this->action = $action;
        $this->comment = $comment;
    }
}
