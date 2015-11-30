<?php namespace A3LWebInterface\Handlers\Events;

use A3LWebInterface\Events\BackupCreated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class EmailBackup
{

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BackupCreated $event
     * @return void
     */
    public function handle($event)
    {
        $email_setting = \Setting::get('email.backup_create', false);
        $receiver = \Setting::get('email.receiver', false);
        if ($email_setting && $receiver != false) {
            $receiver = \A3LWebInterface\User::find($receiver)->first();
            $filename = $event->filename;

            \Mail::queue('emails.backup', [], function ($message) use ($receiver, $filename) {
                $message->to($receiver->email, $receiver->name)->subject('[A3L WebInterface] Database Backup');
                $message->attach(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $filename);
            });
        }
    }

}
