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

    public function getShow(User $user)
    {
        $this->authorize('view', $user);

        return view('app.user.single')->with([
            'user' => $user,
            'readonly' => true,
        ]);
    }

    public function getEdit(User $user)
    {
        $this->authorize('edit', $user);

        return view('app.user.single')->with([
            'user' => $user,
            'readonly' => false,
        ]);
    }

    public function postEdit(User $user)
    {
        $this->authorize('edit', $user);

        $data = \Input::all();
        $validator = \Validator::make($data, User::$rules['update']);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->update($data);
        return redirect('app/user/edit/'.$user->getKey());
    }

    public function getDelete(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect('app/user');
    }
}
