<?php

namespace App\Http\Controllers\App;

use App\Player;
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
        if (\Auth::user()->can('edit-money', $player)) {
            $allowedFields->push(['cash', 'bankacc', 'manipulate_bankacc', 'banking_pin']);
        }
        if (\Auth::user()->can('edit-civ', $player)) {
            $allowedFields->push(['civ_licenses']);
        }
        if (\Auth::user()->can('edit-cop', $player)) {
            $allowedFields->push(['coplevel', 'cop_licenses']);
        }
        if (\Auth::user()->can('edit-medic', $player)) {
            $allowedFields->push(['mediclevel', 'med_licenses']);
        }
        if (\Auth::user()->can('edit-admin', $player)) {
            $allowedFields->push(['adminlevel']);
        }
        if (\Auth::user()->can('edit-donator', $player)) {
            $allowedFields->push(['donorlevel']);
        }
        $allowedFields = $allowedFields->flatten()->toArray();
        $data = array_intersect_key($data, array_combine($allowedFields, $allowedFields));
        if (in_array('manipulate_bankacc', $allowedFields)) {
            $data['bankacc'] += $data['manipulate_bankacc'];
        }
        if (array_key_exists('banking_pin', $data) && empty($data['banking_pin'])) {
            unset($data['banking_pin']);
        }
        $player->update($data);

        return redirect('app/player/edit/'.$player->getKey());
    }

    public function getDelete(Player $player)
    {
        $this->authorize('delete', $player);
        $player->delete();

        return redirect('app/player');
    }
}
