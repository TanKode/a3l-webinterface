<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Helper\Log;
use A3LWebInterface\Http\Requests;
use A3LWebInterface\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!\Auth::User()->isAllowed('manage_roles')) {
			return Redirect::to('/');
		}

		return view('role/list');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        if(!\Auth::User()->isAllowed('manage_roles')) {
            return Redirect::to('/');
        }

        $validator = Validator::make(Input::all(), Role::$rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $role = new Role();
        $role->name = Input::get('name');
        $role->display_name = Input::get('display_name');
        $role->description = Input::get('description');
        $role->save();

		\Event::fire(new \A3LWebInterface\Events\RoleCreated($role, Input::get('comment')));

        if(count(Input::get('permissions')) > 0) {
            $role->attachPermissions(Input::get('permissions'));
        }

        return redirect()->back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!\Auth::User()->isAllowed('manage_roles')) {
            return Redirect::to('/');
        }

        return view('role/edit')->with(array('role' => Role::find($id)));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if(!\Auth::User()->isAllowed('manage_roles')) {
            return Redirect::to('/');
        }

        $rules = Role::$rules;
        $rules['name'] = 'required|alpha_dash|max:255|exists:roles';

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $role = Role::find($id);
        $role->name = Input::get('name');
        $role->display_name = Input::get('display_name');
        $role->description = Input::get('description');
        $role->save();

		\Event::fire(new \A3LWebInterface\Events\RoleUpdated($role, Input::get('comment')));

        $role->perms()->sync([]);
        if(count(Input::get('permissions')) > 0) {
            $role->attachPermissions(Input::get('permissions'));
        }

        return redirect()->route('role.list');
	}

}
