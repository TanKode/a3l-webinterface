<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage', User::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        return view('app.user.index')->with([
            'users' => User::all(),
        ]);
    }

    public function getEdit($id)
    {
        $user = User::id($id)->firstOrFail();
        if(!\Auth::User()->canAssignRole($user->role)) {
            abort(403);
        }
        return view('app.user.edit')->with([
            'user' => $user,
            'selectable_roles' => \Auth::User()->assignableRoles()->keyBy('id')->transform(function ($item, $key) {
                    return $item->name;
                })->toArray(),
        ]);
    }

    public function postUpdate($id)
    {
        $user = User::id($id)->firstOrFail();
        if(!\Auth::User()->canAssignRole($user->role)) {
            abort(403);
        }

        $data = array_filter(\Input::only('email', 'password', 'password_confirmation', 'role_id'));
        $validator = \Validator::make($data, User::$rules['update']);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        unset($data['password_confirmation']);

        foreach($data as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
        return back();
    }
}
