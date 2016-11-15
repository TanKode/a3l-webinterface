<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Fenos\Notifynder\Models\Notification;

class NotificationController extends Controller
{
    public function getRead($id)
    {
        $notification = Notification::find($id);
        if($notification->to_id == \Auth::User()->id) {
            $notification->update(['read' => true]);
            $return = $notification->url == '#' ? back() : redirect($notification->url);
            return $return;
        }
        return back();
    }

    public function getReadall()
    {
        \Auth::User()->readAllNotifications();
        return back();
    }
}
