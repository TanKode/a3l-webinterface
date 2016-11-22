<?php

namespace App\Policies\Forum;

use Riari\Forum\Models\Category;

class CategoryPolicy
{
    /**
     * Permission: Create threads in category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function createThreads()
    {
        return true;
    }

    /**
     * Permission: Manage threads in category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function manageThreads($user, Category $category)
    {
        return $this->deleteThreads($user, $category) ||
        $this->enableThreads($user, $category) ||
        $this->moveThreadsFrom($user, $category) ||
        $this->lockThreads($user, $category) ||
        $this->pinThreads($user, $category);
    }

    /**
     * Permission: Delete threads in category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function deleteThreads()
    {
        return false;
    }

    /**
     * Permission: Enable threads in category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function enableThreads()
    {
        return true;
    }

    /**
     * Permission: Move threads from category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function moveThreadsFrom()
    {
        return true;
    }

    /**
     * Permission: Move threads to category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function moveThreadsTo()
    {
        return true;
    }

    /**
     * Permission: Lock threads in category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function lockThreads()
    {
        return true;
    }

    /**
     * Permission: Pin threads in category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function pinThreads()
    {
        return true;
    }

    /**
     * Permission: View category. Only takes effect for 'private' categories.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function view()
    {
        return false;
    }

    /**
     * Permission: Delete category.
     *
     * @param  object $user
     * @param  Category $category
     * @return bool
     */
    public function delete()
    {
        return false;
    }
}
