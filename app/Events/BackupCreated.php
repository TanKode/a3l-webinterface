<?php namespace A3LWebInterface\Events;

use A3LWebInterface\Events\Event;

use Illuminate\Queue\SerializesModels;

class BackupCreated extends Event
{

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

}
