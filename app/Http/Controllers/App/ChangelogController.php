<?php
namespace App\Http\Controllers\App;

use App\Changelog;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChangelogController extends Controller
{
    public function getIndex()
    {
        return view('app.changelog.index')->with([
            'changelogs' => Changelog::orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function postStore(Request $request)
    {
        if(!\Auth::User()->can('manage', Changelog::class)) {
            abort(403);
        }
        $data = \Input::only('title', 'content');
        $data['slug'] = str_slug($data['title']);
        $validator = \Validator::make($data, Changelog::$rules['create']);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $changelog = new Changelog($data);
        $changelog->author_id = \Auth::User()->id;
        $changelog->save();
        return back();
    }

    public function getEdit($id)
    {
        if(!\Auth::User()->can('manage', Changelog::class)) {
            abort(403);
        }
        return view('app.changelog.edit')->with([
            'changelog' => Changelog::id($id)->firstOrFail(),
        ]);
    }

    public function postUpdate(Request $request, $id)
    {
        $data = \Input::only('title', 'content');
        $data['slug'] = str_slug($data['title']);
        $validator = \Validator::make($data, Changelog::$rules['update']);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $changelog = Changelog::id($id)->firstOrFail();
        $changelog->author_id = \Auth::User()->id;
        $changelog->fill($data);
        $changelog->save();
        return back();
    }

    public function getDelete($id)
    {
        if(!\Auth::User()->can('manage', Changelog::class)) {
            abort(403);
        }
        Changelog::id($id)->firstOrFail()->delete();
        return back();
    }
}
