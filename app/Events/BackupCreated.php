<?php
namespace App\Events;

class BackupCreated extends Event
{
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
}
