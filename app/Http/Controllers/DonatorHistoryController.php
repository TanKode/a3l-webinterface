<?php namespace A3LWebInterface\Http\Controllers;

use A3LWebInterface\Donatorhistory;
use A3LWebInterface\Http\Requests;
use A3LWebInterface\Http\Controllers\Controller;
use A3LWebInterface\Player;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DonatorHistoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!\Auth::User()->isAllowed('view_donators')) {
            return Redirect::to('/');
        }

        return view('donator/list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (!\Auth::User()->isAllowed('add_donator')) {
            return Redirect::to('/');
        }

        $validator = Validator::make(Input::all(), Donatorhistory::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $player = Player::where('playerid', Input::get('player_id'))->first();
        $player->donatorlvl = \Setting::get('player.max_donator_level', 5);
        $player->save();

        $donator = new Donatorhistory();
        $donator->editor_id = Auth::User()->id;
        $donator->editor_name = Auth::User()->name;
        $donator->player_id = $player->playerid;
        $donator->player_name = $player->name;
        $donator->date = Input::get('date');
        $donator->amount = Input::get('amount');
        $donator->duration = Input::get('duration');
        $donator->method = Input::get('method');
        $donator->comment = Input::get('comment');
        $donator->save();

        return redirect()->route('donator.list');
    }

    public function history($id)
    {
        if (!\Auth::User()->isAllowed('view_donators')) {
            return Redirect::to('/');
        }

        $player = Player::find($id);

        return view('donator/history')->with(array('player' => $player));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!\Auth::User()->isAllowed('delete_donator')) {
            return Redirect::to('/');
        }

        $player = Player::find($id);
        $player->donatorlvl = 0;
        $player->save();

        $donator = new Donatorhistory();
        $donator->editor_id = Auth::User()->id;
        $donator->editor_name = Auth::User()->name;
        $donator->player_id = $player->playerid;
        $donator->player_name = $player->name;
        $donator->comment = Input::get('comment');
        $donator->save();

        return redirect()->route('donator.list');
    }

}
