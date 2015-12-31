<?php
namespace App\Http\Controllers\App\Forum;

use Illuminate\Http\Request;

use App\Http\Requests;
use Riari\Forum\Models\Category;

class CategoryController extends Controller
{
    public function getIndex()
    {
        $categories = $this->api('category.index')
            ->parameters(['where' => ['category_id' => 0], 'orderBy' => 'weight', 'with' => ['children']])
            ->get();

        return view('app.forum.category.index', [
            'categories' => $categories,
        ]);
    }

    public function getShow(Category $category)
    {
        return view('app.forum.category.show', [
            'category' => $category,
        ]);
    }

    public function getCreate()
    {
        return view('app.forum.category.create');
    }
}
