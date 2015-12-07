<?php
namespace App\Http\Controllers\App;

use App\Ability;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Silber\Bouncer\Database\Role;

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
        ]);
    }
}
