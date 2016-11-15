<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage', Role::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        return view('app.role.index')->with([
            'roles' => Role::all(),
            'abilities' => Ability::all()->keyBy('id')->transform(function ($item, $key) {
                return $item->slug;
            })->toArray(),
        ]);
    }

    public function postStore()
    {
        $data = array_filter(\Input::only('name', 'abilities'));
        \Bouncer::allow('admin')->to('manage-'.str_slug($data['name']).'-role');
        foreach($data['abilities'] as $abilityId) {
            $ability = Ability::where('id', $abilityId)->firstOrFail();
            \Bouncer::allow(str_slug($data['name']))->to($ability->name, $ability->entity_type, $ability->entity_id);
        }
        return back();
    }

    public function getEdit($id)
    {
        $role = Role::where('id', $id)->firstOrFail();
        if(!\Auth::User()->canAssignRole($role)) {
            abort(403);
        }
        return view('app.role.edit')->with([
            'role' => $role,
            'abilities' => Ability::all()->keyBy('id')->transform(function ($item, $key) {
                return $item->slug;
            })->toArray(),
        ]);
    }

    public function postUpdate($id)
    {
        $role = Role::where('id', $id)->firstOrFail();
        if(!\Auth::User()->canAssignRole($role)) {
            abort(403);
        }
        $abilityIds = \Input::get('abilities', []);
        $role->abilities()->sync($abilityIds);
        return back();
    }
}
