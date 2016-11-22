<?php

namespace App\Policies\Forum;

use Riari\Forum\Models\Post;

class PostPolicy
{
    /**
     * Permission: Edit post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function edit($user, Post $post)
    {
        return $user->id === $post->author_id;
    }

    /**
     * Permission: Delete post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function delete()
    {
        return false;
    }
}
