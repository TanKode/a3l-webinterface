<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Handlers\Events\WebLogAction;
use A3LWebInterface\Helper\Log;
use A3LWebInterface\Http\Requests;
use A3LWebInterface\Vehicle;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller {

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
		if(!\Auth::User()->isAllowed('view_vehicles')) {
			return Redirect::to('/');
		}

		return view('vehicle/list');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!\Auth::User()->isAllowed('edit_vehicle')) {
            return Redirect::to('/');
        }

        return view('vehicle/edit')->with(array('vehicle' => Vehicle::find($id)));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if(!\Auth::User()->isAllowed('edit_vehicle')) {
            return Redirect::to('/');
        }

        $rules = Vehicle::$rules;
        $rules['comment'] = 'required';

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $vehicle = Vehicle::find($id);
        $vehicle->classname = Input::get('classname');
        $vehicle->type = Input::get('type');
        $vehicle->side = Input::get('side');
        $vehicle->pid = Input::get('pid');
        $vehicle->plate = Input::get('plate');
        $vehicle->color = Input::get('color');
        $vehicle->alive = Input::get('alive', 0);
        $vehicle->active = Input::get('active', 0);
        $vehicle->save();

        \Event::fire(new \A3LWebInterface\Events\VehicleUpdated($vehicle, Input::get('comment')));

        return redirect()->route('vehicle.list');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!\Auth::User()->isAllowed('delete_vehicle')) {
            return Redirect::to('/');
        }

        $rules = array();
        $rules['comment'] = 'required';

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $vehicle = Vehicle::find($id);
        \Event::fire(new \A3LWebInterface\Events\VehicleDeleted($vehicle, Input::get('comment')));
        $vehicle->delete();

        return redirect()->route('vehicle.list');
	}

}
