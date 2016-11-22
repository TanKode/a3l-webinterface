<?php

namespace App\Http\Controllers\App\Forum;

use Illuminate\Http\Request;
use Riari\Forum\Models\Category;
use Riari\Forum\Models\Post;
use Riari\Forum\Models\Thread;

class PostController extends Controller
{
    public function getEdit(Category $category, Thread $thread, Post $post)
    {
        $this->authorize('edit', $post);
        if ($post->trashed()) {
            return abort(404);
        }

        $thread = $post->thread;
        $category = $thread->category;

        return view('app.forum.post.edit')->with([
            'category' => $category,
            'thread' => $thread,
            'post' => $post,
        ]);
    }

    public function postEdit(Request $request, Category $category, Thread $thread, Post $post)
    {
        $this->authorize('edit', $post);

        $post = $this->api('post.update', $post->getKey())->parameters($request->only('content'))->patch();

        return back();
    }

    public function getDelete(Request $request, Category $category, Thread $thread, Post $post)
    {
        $this->authorize('delete', $post);

        $permanent = ! config('forum.preferences.soft_deletes');

        $parameters = $request->all();

        if ($permanent) {
            $parameters['force'] = 1;
        }

        if ($thread->posts()->count() == 1) {
            return redirect('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey().'/delete');
        } else {
            $this->api('post.delete', $post->getKey())->parameters($parameters)->delete();
        }

        return redirect('app/forum/category/'.$category->getKey().'/thread/'.$thread->getKey());
    }
}
