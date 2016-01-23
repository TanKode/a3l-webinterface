<?php
namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard.index')->with([
            'dynmarket' => collect(json_decode(\DB::connection('arma')->table('dynmarket')->first()->prices))->unique(0)->sortByDesc(1),
        ]);
    }

    public function getTest()
    {
        \Config::set('app.debug', true);



        abort(403);
    }
}
