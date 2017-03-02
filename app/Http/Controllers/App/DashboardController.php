<?php

namespace App\Http\Controllers\App;

use App\Statlog;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard.index')->with([
            'dynmarket' => collect(json_decode(\DB::connection('arma')->table('dynmarket')->first()->prices))->unique(0)->sortByDesc(1),
            'a3lserver' => $this->getLife(),
            'ts3server' => $this->getTeamspeak(),
        ]);
    }
}
