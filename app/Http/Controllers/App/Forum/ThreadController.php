<?php
namespace App\Http\Controllers\App\Forum;

use Illuminate\Http\Request;

use App\Http\Requests;
use Riari\Forum\Models\Category;
use Riari\Forum\Models\Thread;

class ThreadController extends Controller
{
    public function getShow(Thread $thread)
    {
        return view('app.forum.thread.show')->with([
            'thread' => $thread,
        ]);
    }
}
