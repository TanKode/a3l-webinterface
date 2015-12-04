<?php
namespace App\Listeners;

use App\User;

class EmailBackup
{
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        $email_setting = \Setting::get('email.backup_create', false);
        $receiver = \Setting::get('email.receiver', false);
        if ($email_setting && $receiver != false) {
            $receiver = User::find($receiver)->first();
            $filename = $event->filename;

            \Mail::queue('emails.backup', [], function ($message) use ($receiver, $filename) {
                $message->to($receiver->email, $receiver->name)->subject('[A3L WebInterface] Database Backup');
                $message->attach(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $filename);
            });
        }
    }

}
