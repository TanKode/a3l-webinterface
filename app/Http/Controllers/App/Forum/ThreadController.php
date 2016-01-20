<?php
namespace App\Http\Controllers\App\Forum;

use Illuminate\Http\Request;

use App\Http\Requests;
use Riari\Forum\Models\Category;
use Riari\Forum\Models\Thread;

class ThreadController extends Controller
{
    public function getShow(Category $category, Thread $thread)
    {
        $this->authorize('view', $category);

        if($category->getKey() != $thread->category_id) abort(404);

        return view('app.forum.thread.show')->with([
            'category' => $category,
            'thread' => $thread,
        ]);
    }

    public function getCreate(Category $category)
    {
        $this->authorize('view', $category);

        return view('app.forum.thread.create', [
            'category' => $category,
        ]);
    }

    public function postCreate(Category $category)
    {
        $this->authorize('view', $category);

        $thread = $this->api('thread.store')->parameters([
            'author_id'     => \Auth::id(),
            'category_id'   => $category->getKey(),
            'title'         => \Input::get('title'),
            'content'       => \Input::get('content'),
        ])->post();

        return redirect('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey());
    }

    public function postReply(Category $category, Thread $thread)
    {
        $this->authorize('view', $category);

        $post = $this->api('post.store')->parameters([
            'thread_id' => $thread->getKey(),
            'author_id' => \Auth::User()->getKey(),
            'post_id'   => 0,
            'content'   => \Input::get('content'),
        ])->post();

        $post->thread->touch();

        return back();
    }
}
