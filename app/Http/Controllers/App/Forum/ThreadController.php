<?php

namespace App\Http\Controllers\App\Forum;

use Illuminate\Http\Request;
use Riari\Forum\Models\Category;
use Riari\Forum\Models\Thread;

class ThreadController extends Controller
{
    public function getShow(Category $category, Thread $thread)
    {
        $this->authorize('view', $category);

        if ($category->getKey() != $thread->category_id) {
            abort(404);
        }

        $thread->readers()->sync([\Auth::id()], false);

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
            'author_id' => \Auth::id(),
            'category_id' => $category->getKey(),
            'title' => \Input::get('title'),
            'content' => \Input::get('content'),
        ])->post();

        return redirect('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey());
    }

    public function postReply(Category $category, Thread $thread)
    {
        $this->authorize('view', $category);

        if ($thread->locked) {
            abort(403);
        }

        $post = $this->api('post.store')->parameters([
            'thread_id' => $thread->getKey(),
            'author_id' => \Auth::User()->getKey(),
            'post_id' => 0,
            'content' => \Input::get('content'),
        ])->post();

        $post->thread->touch();
        $thread->readers()->sync([]);

        return back();
    }

    public function getPin(Request $request, Category $category, Thread $thread)
    {
        $this->authorize('edit', $thread);

        $thread = $this->api('thread.pin', $thread->getKey())->parameters($request->all())->patch();

        return back();
    }

    public function getUnpin(Request $request, Category $category, Thread $thread)
    {
        $this->authorize('edit', $thread);

        $thread = $this->api('thread.unpin', $thread->getKey())->parameters($request->all())->patch();

        return back();
    }

    public function getLock(Request $request, Category $category, Thread $thread)
    {
        $this->authorize('edit', $thread);

        $thread = $this->api('thread.lock', $thread->getKey())->parameters($request->all())->patch();

        return back();
    }

    public function getUnlock(Request $request, Category $category, Thread $thread)
    {
        $this->authorize('edit', $thread);

        $thread = $this->api('thread.unlock', $thread->getKey())->parameters($request->all())->patch();

        return back();
    }

    public function getDelete(Request $request, Category $category, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $permanent = ! config('forum.preferences.soft_deletes');

        $parameters = $request->all();

        if ($permanent) {
            $parameters['force'] = 1;
        }

        $thread = $this->api('thread.delete', $thread->getKey())->parameters($parameters)->delete();

        return redirect('app/forum/category/'.$category->getKey());
    }
}
