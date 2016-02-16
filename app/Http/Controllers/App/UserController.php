<?php
namespace App\Http\Controllers\App;

use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Venturecraft\Revisionable\Revision;

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

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        if ($user->email != array_get($data, 'email', $user->email)) {
            $user->unconfirm();
        }

        $user->fill($data);
        if (!is_null(array_get($data, 'role', null))) {
            $roles = array_get($data, 'role', []);
            if (count($user->role) != count(array_intersect($user->role, $roles)) || count($roles) != count(array_intersect($user->role, $roles))) {
                \DB::table((new Revision())->getTable())->insert([
                    'revisionable_type' => get_class($user),
                    'revisionable_id' => $user->getKey(),
                    'key' => 'role',
                    'old_value' => json_encode($user->role),
                    'new_value' => json_encode($roles),
                    'user_id' => \Auth::check() ? \Auth::id() : null,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            }
            $user->role = $roles;
        }
        $user->save();
        $user->assign('member');
        return redirect('app/user/edit/' . $user->getKey());
    }

    public function getDelete(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect('app/user');
    }

    public function getReadNotify($notificationId)
    {
        if (empty($notificationId)) {
            \Auth::User()->readAllNotifications();
        } else {
            \Notify::readOne($notificationId);
        }
        return back();
    }

    public function getSendVerificationMail(User $user)
    {
        $this->authorize('edit', $user);

        if (!$user->confirmed && $user->confirmation_token != '') {
            $user->sendVerificationEmail();
        }
        return back();
    }
}
