<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Helper\Formatter;
use A3LWebInterface\Helper\Log;
use A3LWebInterface\Http\Requests;
use A3LWebInterface\Player;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
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
        if (!\Auth::User()->isAllowed('view_players')) {
            return Redirect::to('/');
        }

        return view('player/list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        if (!\Auth::User()->isAllowed('view_players') || \Auth::User()->player->uid != $id) {
            return Redirect::to('/');
        }

        return view('player/profile')->with(array('player' => Player::find($id)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        if (!\Auth::User()->isAllowed('edit_player')) {
            return Redirect::to('/');
        }

        return view('player/edit')->with(array('player' => Player::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        if (!\Auth::User()->isAllowed('edit_player')) {
            return Redirect::to('/');
        }

        $rules = Player::$rules;
        $rules['comment'] = 'required';
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $player = Player::find($id);
        $old_civ_licenses = Formatter::decodeDBArray($player->civ_licenses);
        $old_cop_licenses = Formatter::decodeDBArray($player->cop_licenses);
        $old_med_licenses = Formatter::decodeDBArray($player->med_licenses);

        foreach ($old_civ_licenses as $key => $value) {
            $value[0] = strtolower($value[0]);
            $setting = \Setting::get('licence.' . $value[0], false);
            if (!$setting) {
                \Setting::set('licence.' . $value[0], $value[0]);
            }
        }
        foreach ($old_cop_licenses as $key => $value) {
            $value[0] = strtolower($value[0]);
            $setting = \Setting::get('licence.' . $value[0], false);
            if (!$setting) {
                \Setting::set('licence.' . $value[0], $value[0]);
            }
        }
        foreach ($old_med_licenses as $key => $value) {
            $value[0] = strtolower($value[0]);
            $setting = \Setting::get('licence.' . $value[0], false);
            if (!$setting) {
                \Setting::set('licence.' . $value[0], $value[0]);
            }
        }
        \Setting::save();

        $ret_civ_licenses = array();
        foreach (\Setting::get('licence') as $key => $value) {
            if (strpos($key, '_civ_') !== false) {
                $new_civ_licenses = Input::get('civ_licenses');
                if (isset($new_civ_licenses['\'' . $key . '\''])) {
                    $ret_civ_licenses[] = [$key => 1];
                } else {
                    $ret_civ_licenses[] = [$key => 0];
                }
            }
        }

        $ret_cop_licenses = array();
        foreach (\Setting::get('licence') as $key => $value) {
            if (strpos($key, '_cop_') !== false) {
                $new_cop_licenses = Input::get('cop_licenses');
                if (isset($new_cop_licenses['\'' . $key . '\''])) {
                    $ret_cop_licenses[] = [$key => 1];
                } else {
                    $ret_cop_licenses[] = [$key => 0];
                }
            }
        }

        $ret_med_licenses = array();
        foreach (\Setting::get('licence') as $key => $value) {
            if (strpos($key, '_med_') !== false) {
                $new_med_licenses = Input::get('med_licenses');
                if (isset($new_med_licenses['\'' . $key . '\''])) {
                    $ret_med_licenses[] = [$key => 1];
                } else {
                    $ret_med_licenses[] = [$key => 0];
                }
            }
        }

        $player->name = Input::get('name');
        $player->playerid = Input::get('playerid');
        $player->cash = Input::get('cash');
        $player->bankacc = Input::get('bankacc');
        $player->coplevel = Input::get('coplevel');
        $player->mediclevel = Input::get('mediclevel');
        $player->civ_licenses = Formatter::encodeDBArray($ret_civ_licenses, true);
        $player->cop_licenses = Formatter::encodeDBArray($ret_cop_licenses, true);
        $player->med_licenses = Formatter::encodeDBArray($ret_med_licenses, true);
        $player->save();

        \Event::fire(new \A3LWebInterface\Events\PlayerUpdated($player, Input::get('comment')));

        return redirect()->route('player.list');
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
