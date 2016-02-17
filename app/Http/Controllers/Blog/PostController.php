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
        ]);
    }

    public function getSingle($slug)
    {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if(is_null($post) && !($post instanceof \WP_Post)) abort(404);
        $GLOBALS['post'] = $post;
        setup_postdata($post);

        global $vc_manager;
        if($vc_manager instanceof \Vc_Manager) {
            dump($vc_manager);
            dump($vc_manager->init());
        }

        return view('wordpress.single')->with([
            'post' => $post,
        ]);
    }
}
