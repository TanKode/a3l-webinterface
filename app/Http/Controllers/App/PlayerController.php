<?php
namespace App\Http\Controllers\App;

use App\Player;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public function getIndex()
    {
        $this->authorize('view-list', Player::class);

        return view('app.player.index')->with([
            'players' => Player::all()->load('user'),
        ]);
    }

    public function getShow(Player $player)
    {
        $this->authorize('view', $player);

        return view('app.player.single')->with([
            'player' => $player,
            'readonly' => true,
        ]);
    }

    public function getEdit(Player $player)
    {
        $this->authorize('edit', $player);

        return view('app.player.single')->with([
            'player' => $player,
            'readonly' => false,
        ]);
    }

    public function postEdit(Player $player)
    {
        $this->authorize('edit', $player);

        $data = \Input::all();
        $validator = \Validator::make($data, Player::$rules['update']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $allowedFields = collect([]);
        if(\Auth::User()->can('edit-money', $player)) $allowedFields->push(['cash', 'bankacc']);
        if(\Auth::User()->can('edit-civ', $player)) $allowedFields->push(['civ_licenses']);
        if(\Auth::User()->can('edit-cop', $player)) $allowedFields->push(['coplevel', 'cop_licenses']);
        if(\Auth::User()->can('edit-medic', $player)) $allowedFields->push(['mediclevel', 'med_licenses']);
        if(\Auth::User()->can('edit-atac', $player)) $allowedFields->push(['ataclevel', 'atac_licenses']);
        if(\Auth::User()->can('edit-admin', $player)) $allowedFields->push(['adminlevel']);
        $allowedFields = $allowedFields->flatten()->toArray();
        $data = array_intersect_key($data, array_combine($allowedFields, $allowedFields));
        $player->update($data);
        return redirect('app/player/edit/' . $player->getKey());
    }

    public function getDelete(Player $player)
    {
        $this->authorize('delete', $player);
        $player->delete();
        return redirect('app/player');
    }
}
