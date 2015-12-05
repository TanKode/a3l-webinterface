<?php
namespace App\Http\Controllers\App;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getIndex()
    {
        $this->authorize('view', User::class);

        return view('app.user.index')->with([
            'users' => User::all(),
        ]);
    }
}
