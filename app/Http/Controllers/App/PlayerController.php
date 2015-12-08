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
        $this->authorize('view', Player::class);

        return view('app.player.index')->with([
            'players' => Player::all(),
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
