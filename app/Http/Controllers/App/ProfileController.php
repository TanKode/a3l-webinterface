<?php
namespace App\Http\Controllers\App;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function getEdit($id)
    {
        if(\Auth::User()->id != $id) {
            abort(403);
        }

        return view('app.profile.edit')->with([
            'user' => User::id($id)->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if(\Auth::User()->id != $id) {
            abort(403);
        }
    }
}
