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

    public function postUpdate(Request $request, $id)
    {
        if(\Auth::User()->id != $id) {
            abort(403);
        }
    }

    public function getDisconnect($id, $provider)
    {
        if(\Auth::User()->id != $id) {
            abort(403);
        }

        $user = User::id($id)->first();
        $user->$provider = null;
        $user->save();
        return back();
    }
}
