<?php
namespace App\Http\Controllers\App\A3L;

use App\A3L\Player;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public function getIndex()
    {
        return view('app.a3l.player.index')->with([
            'players' => Player::all(),
        ]);
    }

    public function getEdit($id)
    {
        return view('app.a3l.player.edit')->with([
            'player' => Player::uid($id)->firstOrFail(),
        ]);
    }
}
