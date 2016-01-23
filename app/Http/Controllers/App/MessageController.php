<?php
namespace App\Http\Controllers\App;

use App\Player;
use App\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function __construct()
    {
        \Config::set('app.debug', true);
        if(!\Auth::User()->hasPlayer()) {
            abort(404);
        }

        view()->share('participants', \Auth::User()->player->getMessageParticipants());
    }

    public function getIndex()
    {
        return view('app.message.index')->with([
            'display_player' => \Auth::User()->player->getMessageParticipants()->first(),
        ]);
    }

    public function getShow(Player $player)
    {
        return view('app.message.index')->with([
            'display_player' => $player,
        ]);
    }
}
