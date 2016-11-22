<?php

namespace App\Http\Controllers\App\Forum;

use Riari\Forum\Frontend\Http\Controllers\BaseController;
use Riari\Forum\Models\Category;

class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $categories = $this->api('category.index')
            ->parameters(['where' => ['category_id' => 0], 'orderBy' => 'weight', 'with' => ['children']])
            ->get();
        view()->share('categoryList', $categories);
    }
}
