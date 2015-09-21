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
        if(!\Auth::User()->can('manage', User::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        $users = User::all();
        return view('app.user.index')->with([
            'users' => $users,
        ]);
    }
}
