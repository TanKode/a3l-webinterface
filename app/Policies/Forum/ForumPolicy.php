<?php

namespace App\Policies\Forum;

class ForumPolicy
{
    /**
     * Permission: Create categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function createCategories()
    {
        return true;
    }

    /**
     * Permission: Manage category.
     *
     * @param  object  $user
     * @return bool
     */
    public function manageCategories($user)
    {
        return $this->moveCategories($user) ||
               $this->renameCategories($user);
    }

    /**
     * Permission: Move categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function moveCategories()
    {
        return true;
    }

    /**
     * Permission: Rename categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function renameCategories()
    {
        return true;
    }

    /**
     * Permission: Mark new/updated threads as read.
     *
     * @param  object  $user
     * @return bool
     */
    public function markNewThreadsAsRead()
    {
        return true;
    }

    /**
     * Permission: View trashed threads.
     *
     * @param  object  $user
     * @return bool
     */
    public function viewTrashedThreads()
    {
        return false;
    }

    /**
     * Permission: View trashed posts.
     *
     * @param  object  $user
     * @return bool
     */
    public function viewTrashedPosts()
    {
        return false;
    }
}
