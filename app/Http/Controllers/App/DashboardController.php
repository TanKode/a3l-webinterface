<?php
namespace App\Http\Controllers\App;

use App\Lotto;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getIndex()
    {
        \Config::set('app.debug', true);
        return view('app.dashboard.index')->with([
            'dynmarket' => collect(json_decode(\DB::connection('arma')->table('dynmarket')->first()->prices))->unique(0)->sortByDesc(1),
            'a3lserver' => $this->getLife(),
            'ts3server' => $this->getTeamspeak(),
            'lotto' => Lotto::next()->first(),
        ]);
    }

    public function getTest()
    {
        \Config::set('app.debug', true);

        dd(\Auth::User()->getNotifications()->first());

        abort(403);
    }
}
