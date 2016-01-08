<?php
namespace App\Http\Controllers\App;

use App\Ability;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function getIndex()
    {
        $this->authorize('view', Role::class);

        return view('app.role.index')->with([
            'roles' => Role::all(),
        ]);
    }

    public function getShow(Role $role)
    {
        $this->authorize('view', $role);

        return view('app.role.single')->with([
            'role' => $role,
            'abilities' => Ability::getList(),
            'readonly' => true,
        ]);
    }

    public function getEdit(Role $role)
    {
        $this->authorize('edit', $role);

        return view('app.role.single')->with([
            'role' => $role,
            'abilities' => Ability::getList(),
            'readonly' => false,
            'action' => 'edit',
        ]);
    }

    public function getCreate()
    {
        $this->authorize('edit', Role::class);

        return view('app.role.single')->with([
            'role' => new Role(),
            'abilities' => Ability::getList(),
            'readonly' => false,
            'action' => 'create',
        ]);
    }

    public function postEdit(Role $role)
    {
        $this->authorize('edit', $role);

        $data = \Input::all();
        $validator = \Validator::make($data, Role::$rules['update']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role->name = array_get($data, 'display_name', '');
        $role->ability = array_get($data, 'ability', []);
        $role->save();
        return redirect('app/role/edit/' . $role->getKey());
    }

    public function postCreate()
    {
        $this->authorize('edit', Role::class);

        $data = \Input::all();
        $validator = \Validator::make($data, Role::$rules['create']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::create(['name' => array_get($data, 'display_name', '')]);
        $role->ability = array_get($data, 'ability', []);
        $role->save();
        return redirect('app/role/edit/' . $role->getKey());
    }
}
