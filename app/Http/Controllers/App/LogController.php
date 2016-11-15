<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;

class LogController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage', Log::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        return view('app.log.index')->with([
            'logs' => Log::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
