<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Gang;
use A3LWebInterface\Libs\Formatter;
use A3LWebInterface\Http\Requests;
use A3LWebInterface\Player;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class GangController extends Controller
{

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
        if (!\Auth::User()->isAllowed('view_gangs')) {
            return Redirect::to('/');
        }

        return view('gang/list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::User()->isAllowed('edit_gang')) {
            return Redirect::to('/');
        }

        return view('gang/edit')->with(array('gang' => Gang::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        if (!\Auth::User()->isAllowed('edit_gang')) {
            return Redirect::to('/');
        }

        $rules = Gang::$rules;
        $rules['comment'] = 'required';
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $members = str_replace('\'', '', Formatter::encodeDBArray(array_keys(Input::get('members'))));

        $gang = Gang::find($id);
        $gang->name = Input::get('name');
        $gang->owner = Input::get('owner');
        $gang->maxmembers = Input::get('maxmembers');
        $gang->members = $members;
        $gang->bank = Input::get('bank');
        $gang->active = Input::get('active', 0);
        $gang->save();

        \Event::fire(new \A3LWebInterface\Events\GangUpdated($gang, Input::get('comment')));

        return redirect()->route('gang.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
