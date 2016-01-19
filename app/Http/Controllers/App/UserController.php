<?php
namespace App\Http\Controllers\App;

use App\Role;
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
            'users' => User::all()->load('player'),
        ]);
    }

    public function getShow(User $user)
    {
        $this->authorize('view', $user);

        return view('app.user.single')->with([
            'user' => $user,
            'roles' => Role::getList(),
            'readonly' => true,
        ]);
    }

    public function getEdit(User $user)
    {
        $this->authorize('edit', $user);

        return view('app.user.single')->with([
            'user' => $user,
            'roles' => Role::getList(),
            'readonly' => false,
        ]);
    }

    public function postEdit(User $user)
    {
        $this->authorize('edit', $user);

        $data = \Input::all();
        $validator = \Validator::make($data, User::$rules['update']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->fill($data);
        $user->role = array_get($data, 'role', []);
        $user->save();
        return redirect('app/user/edit/' . $user->getKey());
    }

    public function getDelete(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect('app/user');
    }
}
