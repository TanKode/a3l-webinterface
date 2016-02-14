<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function getShow(Request $request, $page)
    {
        $page = str_slug($page);
        $path = base_path('resources/pages/'.$page.'.md');
        if(\File::exists($path)) {
            return view('page')->with([
                'content' => \File::get($path),
            ]);
        } else {
            abort(404);
        }
    }
}
