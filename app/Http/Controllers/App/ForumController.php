<?php namespace App\Http\Controllers\App;

use Fenos\Notifynder\Builder\NotifynderBuilder;
use Illuminate\Support\Collection;
use Riari\Forum\Libraries\Alerts;
use Riari\Forum\Libraries\Utils;
use Riari\Forum\Libraries\Validation;
use View;
use Riari\Forum\Repositories\Categories;
use Riari\Forum\Repositories\Threads;
use Riari\Forum\Repositories\Posts;
use Riari\Forum\Controllers\BaseController;

class ForumController extends BaseController
{
    public function __construct(Categories $categories, Threads $threads, Posts $posts)
    {
        if (\Auth::guest()) {
            redirect()->guest('auth/login')->send();
        }
        parent::__construct($categories, $threads, $posts);
        $this->collections['categories'] = $this->categories->getAll();
    }

    public function postReplyToThread($categoryID, $categoryAlias, $threadID, $threadAlias)
    {
        $user = Utils::getCurrentUser();

        $this->load(['category' => $categoryID, 'thread' => $threadID]);

        if (!$this->collections['thread']->canReply) {
            return \Redirect::to($this->collections['thread']->route);
        }

        $post_valid = Validation::check('post');
        if ($post_valid) {
            $post = array(
                'parent_thread' => $threadID,
                'author_id' => $user->id,
                'content' => \Input::get('content')
            );

            $post = $this->posts->create($post);
            $post->thread->touch();

            $contributers = new Collection();
            foreach($post->thread->posts as $single) {
                $author = $single->author;
                if($author->id != $post->author->id)
                $contributers->put($author->id, $author);
            }
            \Notifynder::loop($contributers, function(NotifynderBuilder $builder, $to) use ($post) {
                $builder->category('forum.reply')
                    ->from($post->author->id)
                    ->to($to->id)
                    ->url($post->thread->route);
            })->send();

            Alerts::add('success', trans('forum::base.reply_added'));
            return \Redirect::to($this->collections['thread']->lastPostRoute);
        } else {
            return \Redirect::to($this->collections['thread']->replyRoute)->withInput();
        }
    }
}
