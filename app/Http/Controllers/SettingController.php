<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Helper\Log;
use A3LWebInterface\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller {

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
		if(!\Auth::User()->isAllowed('manage_settings')) {
			return Redirect::to('/');
		}

		return view('setting/list');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        if(!\Auth::User()->isAllowed('manage_settings')) {
            return Redirect::to('/');
        }

        $rules = array(
            'key' => 'required|max:255|unique:settings',
            'value' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        \Setting::set(Input::get('key'), Input::get('value'));
        \Setting::save();

        return redirect()->back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(!\Auth::User()->isAllowed('manage_settings')) {
			return Redirect::to('/');
		}

		$rules = array(
			'value' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);
		if($validator->fails()) {
			return redirect()->back()->withInput()->withErrors($validator->errors());
		}

		\Setting::set($id, Input::get('value'));
		\Setting::save();

		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!\Auth::User()->isAllowed('manage_settings')) {
            return Redirect::to('/');
        }

        \Setting::forget($id);
        \Setting::save();

        return redirect()->back();
	}

}
