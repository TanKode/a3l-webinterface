<?php
namespace App\Http\Controllers\App;

use App\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function __construct()
    {
        view()->share('threads', Thread::forUser(\Auth::id())->latest('updated_at')->get());
        view()->share('recipients', User::getList(\Auth::id()));
    }

    public function getIndex()
    {
        return view('app.chat.index')->with([
            'display_thread' => Thread::getAllLatest()->first(),
        ]);
    }

    public function getCreate()
    {
        return view('app.chat.index')->with([
            'display_thread' => null,
        ]);
    }

    public function getShow(Thread $thread)
    {
        if(!$thread->hasParticipant(\Auth::id())) {
            abort(404);
        }

        return view('app.chat.index')->with([
            'display_thread' => $thread,
        ]);
    }

    public function postCreate()
    {
        $thread = \Auth::User()->createThread(\Input::get('recipients', []), \Input::get('body', ''));

        return redirect('app/chat/' . $thread->getKey());
    }

    public function postReply(Thread $thread)
    {
        if(!$thread->hasParticipant(\Auth::id())) {
            abort(404);
        }

        Message::create([
            'thread_id' => $thread->getKey(),
            'user_id' => \Auth::id(),
            'body' => \Input::get('body', ''),
        ]);

        return redirect('app/chat/' . $thread->getKey());
    }
}
