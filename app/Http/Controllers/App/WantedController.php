<?php

namespace App\Http\Controllers\App;

use App\Wanted;
use App\Http\Controllers\Controller;

class WantedController extends Controller
{
    public function getIndex()
    {
        $wanteds = Wanted::active()->get();

        return view('app.wanted.index')->with([
            'wanteds' => $wanteds,
        ]);
    }
}
