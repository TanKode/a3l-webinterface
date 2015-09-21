<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Silber\Bouncer\Database\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        if(!\Auth::User()->can('manage', Role::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        $roles = Role::all();
        return view('app.role.index')->with([
            'roles' => $roles,
        ]);
    }
}
