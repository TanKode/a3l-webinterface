<?php
namespace App\Http\Controllers\App;

use App\Gitlab\Issue;
use App\Gitlab\Projects;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Riari\Forum\Models\Post;
use Riari\Forum\Models\Thread;

class IssueController extends Controller
{
    public function getIndex()
    {
        return view('app.issue.index')->with([
            'issues' => Issue::all()->sortBy('project_id'),
        ]);
    }

    public function postStore()
    {
        $data = array_filter(\Input::only('project_id', 'title', 'description', 'forum'));
        $validator = \Validator::make($data, Issue::$rules);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Issue::create($data['project_id'], [
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        if(!empty($data['forum'])) {
            $thread = array(
                'author_id'       => \Auth::User()->id,
                'parent_category' => Projects::$CATEGORIES[$data['project_id']],
                'title'           => $data['title'],
            );

            $thread = Thread::create($thread);

            $post = array(
                'parent_thread'   => $thread->id,
                'author_id'       => \Auth::User()->id,
                'content'         => $data['description'],
            );

            Post::create($post);
        }

        return back();
    }
}