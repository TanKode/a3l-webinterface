<?php

namespace App\Http\Controllers\App\Forum;

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
        $this->authorize('view', $category);

        return view('app.forum.category.show')->with([
            'category' => $category->load('children'),
        ]);
    }

    public function getCreate()
    {
        $this->authorize('edit', Category::class);

        return view('app.forum.category.create_edit')->with([
            'action' => 'create',
            'category' => new Category(),
        ]);
    }

    public function getEdit(Category $category)
    {
        $this->authorize('edit', $category);

        return view('app.forum.category.create_edit')->with([
            'action' => 'edit',
            'category' => $category,
        ]);
    }

    public function postCreate()
    {
        $this->authorize('edit', Category::class);

        $category = $this->api('category.store')->parameters(\Input::all())->post();

        \Bouncer::allow('superadmin')->to('view', $category);

        return redirect('app/forum/category/'.$category->getKey());
    }

    public function postEdit(Category $category)
    {
        $category = $this->api('category.rename', $category->getKey())->parameters(\Input::all())->patch();
        if (\Input::get('category_id')) {
            $category = $this->api('category.move', $category->getKey())->parameters(\Input::all())->patch();
        }

        \Bouncer::allow('superadmin')->to('view', $category);

        return redirect('app/forum/category/'.$category->getKey());
    }

    public function getDelete(Category $category)
    {
        $this->api('category.delete', $category->getKey())->parameters(\Input::all())->delete();

        return redirect('app/forum');
    }
}
