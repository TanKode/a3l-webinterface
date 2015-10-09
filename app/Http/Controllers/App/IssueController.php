<?php
namespace App\Http\Controllers\App;

use App\Gitlab\Issue;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IssueController extends Controller
{
    public function getIndex()
    {
        return view('app.issue.index')->with([
            'issues' => Issue::all()->sortBy('project_id'),
        ]);
    }

    public function postStore()
    {
        $data = array_filter(\Input::only('project_id', 'title', 'description'));
        $validator = \Validator::make($data, Issue::$rules);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Issue::create($data['project_id'], [
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
        return back();
    }
}