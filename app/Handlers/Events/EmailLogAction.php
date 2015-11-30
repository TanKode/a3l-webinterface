<?php namespace A3LWebInterface\Handlers\Events;

use A3LWebInterface\Events\UserDeleted;

use A3LWebInterface\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use PhpParser\Node\Expr\Cast\Object_;

class EmailLogAction
{

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UserDeleted $event
     * @return void
     */
    public function handle($event)
    {
        $table = $event->model->getTable();
        $setting_name = strtolower('email.' . $table . '_' . $event->action);
        $email_setting = \Setting::get($setting_name, false);
        $receiver = \Setting::get('email.receiver', false);
        if ($email_setting != false && $receiver != false) {
            $object = false;
            $owner = false;
            $receiver = \A3LWebInterface\User::find($receiver)->first();

            if ($table == 'users' && $event->action == 'CREATE') {
                $editor['id'] = 0;
                $editor['name'] = 'Server';
            } else {
                $editor['id'] = \Auth::User()->id;
                $editor['name'] = \Auth::User()->name;
            }

            switch ($table):
                case 'players':
                    $object['id'] = $event->model->uid;
                    $object['name'] = $event->model->name;
                    break;
                case 'vehicles':
                    $owner = \A3LWebInterface\Player::where('playerid', $event->model->pid)->first();
                    $object['id'] = $event->model->id;
                    $object['name'] = $event->model->classname;
                    $owner['id'] = $owner->uid;
                    $owner['name'] = $owner->name;
                    break;
                default:
                    $object['id'] = $event->model->id;
                    $object['name'] = $event->model->name;
                    break;
            endswitch;

            switch ($event->action):
                case 'CREATE':
                    $color = '#2D8332';
                    break;
                case 'UPDATE':
                    $color = '#F9C23D';
                    break;
                case 'DELETE':
                    $color = '#C68144';
                    break;
                default:
                    $color = '#888888';
                    break;
            endswitch;

            \Mail::queue('emails.logreport', [
                'table' => $table,
                'editor' => $editor,
                'object' => $object,
                'owner' => $owner,
                'action' => $event->action,
                'comment' => $event->comment,
                'color' => $color,
            ], function ($message) use ($receiver) {
                $message->to($receiver->email, $receiver->name)->subject('[A3L WebInterface] Log Action Report');
            });
        }
    }

}
