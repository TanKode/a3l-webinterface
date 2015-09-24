<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Silber\Bouncer\Database\Ability;

class AbilityController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage', Ability::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        return view('app.ability.index')->with([
            'abilities' => Ability::all(),
        ]);
    }
}
