<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PageController extends Controller
{
    public function getShow(Request $request, $page)
    {
        \Config::set('app.debug', true);
        $page = str_slug($page);
        $query = new \WP_Query([
            'post_type' => 'page',
            'posts_per_page' => 1,
            'name' => $page,
        ]);
        $post = array_get($query->get_posts(), 0);
        if (! is_null($post) && $post instanceof \WP_Post) {
            return view('page')->with([
                'wppost' => $post,
            ]);
        } else {
            $path = base_path('resources/pages/'.$page.'.md');
            if (\File::exists($path)) {
                return view('page')->with([
                    'content' => \File::get($path),
                ]);
            } else {
                abort(404);
            }
        }
    }
}
