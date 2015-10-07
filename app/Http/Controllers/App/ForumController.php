<?php namespace App\Http\Controllers\App;

use View;
use Riari\Forum\Repositories\Categories;
use Riari\Forum\Repositories\Threads;
use Riari\Forum\Repositories\Posts;

class ForumController extends \Riari\Forum\Controllers\BaseController
{
    public function __construct(Categories $categories, Threads $threads, Posts $posts)
    {
        parent::__construct($categories, $threads, $posts);
        $this->collections['categories'] = $this->categories->getAll();
    }
}
