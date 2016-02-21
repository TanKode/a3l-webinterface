<?php
namespace App\Http\Controllers\App;

use App\Lotto;
use App\Statlog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard.index')->with([
            'dynmarket' => collect(json_decode(\DB::connection('arma')->table('dynmarket')->first()->prices))->unique(0)->sortByDesc(1),
            'a3lserver' => $this->getLife(),
            'ts3server' => $this->getTeamspeak(),
            'lotto' => Lotto::next()->first(),
            'statlogs' => Statlog::orderBy('created_at', 'desc')->take(28)->get(),
            'post' => array_get(wp_get_recent_posts([
                'numberposts' => 1,
            ], OBJECT), 0),
        ]);
    }

    public function getTest()
    {
        \Config::set('app.debug', true);

        dd(array_get(wp_get_recent_posts([
            'numberposts' => 1,
        ], OBJECT), 0));

        abort(403);
    }
}
