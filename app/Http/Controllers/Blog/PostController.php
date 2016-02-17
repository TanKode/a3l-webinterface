<?php
namespace App\Http\Controllers\Blog;

use App\Lotto;
use App\Statlog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function getIndex()
    {
        $query = new \WP_Query(array(
            'posts_per_page' => -1,
            'order' => 'desc',
            'orderby' => 'post_date',
        ));

        $posts = $query->get_posts();

        return view('wordpress.index')->with([
            'posts' => $posts,
            'category' => null,
        ]);
    }

    public function getCategory($category)
    {
        $category = get_cat_ID($category);
        $query = new \WP_Query(array(
            'posts_per_page' => -1,
            'order' => 'desc',
            'orderby' => 'post_date',
            'cat' => $category,
        ));

        $category = get_category($category);

        $posts = $query->get_posts();

        return view('wordpress.index')->with([
            'posts' => $posts,
            'category' => $category,
        ]);
    }

    public function getSingle($slug)
    {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if(is_null($post) && !($post instanceof \WP_Post)) abort(404);

        return view('wordpress.single')->with([
            'post' => $post,
        ]);
    }
}
