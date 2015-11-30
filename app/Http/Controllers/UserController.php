<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Helper\Log;
use A3LWebInterface\Http\Requests;
use A3LWebInterface\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        if (!\Auth::User()->isAllowed('view_users')) {
            return Redirect::to('/');
        }

        return view('user/list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::User()->isAllowed('edit_user')) {
            return Redirect::to('/');
        }

        return view('user/edit')->with(array('user' => User::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        if (!\Auth::User()->isAllowed(['edit_user', 'edit_user_' . Input::get('role')], true)) {
            return Redirect::to('/');
        }

        $rules = User::$rules;
        $rules['name'] = 'required|alpha_dash|max:255|exists:users';
        $rules['email'] = 'required|email|max:255|exists:users';
        $rules['player_id'] = 'required|numeric|exists:users';
        $rules['password'] = '';
        $rules['comment'] = 'required';

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $user = User::find($id);
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->player_id = Input::get('player_id');
        $user->save();

        $user->roles()->sync([]);
        $user->attachRole(Input::get('role'));

        \Event::fire(new \A3LWebInterface\Events\UserUpdated($user, Input::get('comment')));

        return redirect()->route('user.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!\Auth::User()->isAllowed(['delete_user', 'delete_user_' . User::find($id)->roles[0]->name], true)) {
            return Redirect::to('/');
        }

        $rules = array();
        $rules['comment'] = 'required';

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $user = User::find($id);
        \Event::fire(new \A3LWebInterface\Events\UserDeleted($user, Input::get('comment')));
        $user->delete();

        return redirect()->route('user.list');
    }

}
