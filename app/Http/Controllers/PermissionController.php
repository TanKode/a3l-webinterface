<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Helper\Log;
use A3LWebInterface\Http\Requests;
use A3LWebInterface\Permission;
use A3LWebInterface\Role;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller {

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
		if(!\Auth::User()->isAllowed('manage_permissions')) {
			return Redirect::to('/');
		}

		return view('permission/list');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(!\Auth::User()->isAllowed('manage_permissions')) {
			return Redirect::to('/');
		}

		$validator = Validator::make(Input::all(), Permission::$rules);
		if($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator->errors());
		}

		$permission = new Permission();
		$permission->name = Input::get('name');
		$permission->display_name = Input::get('display_name');
		$permission->description = Input::get('description');
		$permission->save();

        \Event::fire(new \A3LWebInterface\Events\PermissionCreated($permission, Input::get('comment')));

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
        return view('permission/edit')->with(array('permission' => Permission::find($id)));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if(!\Auth::User()->isAllowed('manage_permissions')) {
            return Redirect::to('/');
        }

        $rules = Permission::$rules;
        $rules['name'] = 'required|alpha_dash|max:255';

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $permission = Permission::find($id);
        $permission->name = Input::get('name');
        $permission->display_name = Input::get('display_name');
        $permission->description = Input::get('description');
        $permission->save();

        \Event::fire(new \A3LWebInterface\Events\PermissionUpdated($permission, Input::get('comment')));

        return redirect()->route('permission.list');
	}

}
