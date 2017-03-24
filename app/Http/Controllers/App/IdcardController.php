<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Player;

class IdcardController extends Controller
{
    public function getReset(Player $player, $side)
    {
        $this->authorize('edit', $player);

        $field = lcfirst(studly_case('perso_' . strtolower($side)));
        $idcard = $player->idcard;
        $idcard->$field = [];
        $idcard->save();

        return redirect()->back();
    }
}
