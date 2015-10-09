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
            'user' => User::id($id)->firstOrFail(),
        ]);
    }

    public function getShow($id)
    {
        return view('app.profile.show')->with([
            'user' => User::id($id)->firstOrFail(),
        ]);
    }

    public function postUpdate(Request $request, $id)
    {
        if(\Auth::User()->id != $id) {
            abort(403);
        }

        $data = array_filter(\Input::only('email', 'password', 'password_confirmation'));
        $validator = \Validator::make($data, User::$rules['update']);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        unset($data['password_confirmation']);

        $user = User::id($id)->firstOrFail();
        foreach($data as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
        return back();
    }

    public function getDisconnect($id, $provider)
    {
        if(\Auth::User()->id != $id) {
            abort(403);
        }

        $user = User::id($id)->firstOrFail();
        $user->$provider = null;
        $user->save();
        return back();
    }
}
