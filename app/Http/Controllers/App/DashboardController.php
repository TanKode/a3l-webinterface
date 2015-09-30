<?php
namespace App\Http\Controllers\App;

use App\A3E\Account as A3eAccount;
use App\A3E\Vehicle as A3eVehicle;
use App\A3E\Territory as A3eTerritory;
use App\A3L\Player as A3lPlayer;
use App\A3L\Vehicle as A3lVehicle;
use App\Accounting;
use App\Gitlab\Issue;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getIndex()
    {
        // ALTIS LIFE
        $sourceQuery = new \SourceQuery();
        $sourceQuery->Connect(env('A3L_HOST', ''), env('A3L_PORT', 2303), 1, \SourceQuery::SOURCE);
        $a3lInfo = $sourceQuery->GetInfo();
        $a3lPlayers = collect($sourceQuery->GetPlayers());
        $sourceQuery->Disconnect();

        $a3lRestart = Carbon::now()->setTimezone('Europe/Berlin');
        $a3lRestart->minute = 0;
        $a3lRestart->second = 0;
        $hours = (ceil($a3lRestart->hour / 6) * 6) - $a3lRestart->hour;
        $hours = $hours == 0 ? 6 : $hours;
        $a3lRestart->addHours($hours);

        // EXILE
        $sourceQuery = new \SourceQuery();
        $sourceQuery->Connect(env('A3E_HOST', ''), env('A3E_PORT', 2303), 1, \SourceQuery::SOURCE);
        $a3eInfo = $sourceQuery->GetInfo();
        $a3ePlayers = collect($sourceQuery->GetPlayers());
        $sourceQuery->Disconnect();

        $a3eRestart = Carbon::now()->setTimezone('Europe/Berlin');
        $a3eRestart->minute = 0;
        $a3eRestart->second = 0;
        if($a3eRestart->hour > 6) {
            $a3eRestart->addDay(1);
        }
        $a3eRestart->hour = 6;

        //GITLAB
        $issues = Issue::all();

        return view('app.dashboard')->with([
            'accounting_sum' => Accounting::sum('amount'),
            'a3l' => [
                'player_count' => A3lPlayer::count(),
                'vehicle_count' => A3lVehicle::count(),
                'money_sum' => A3lPlayer::sum('cash') + A3lPlayer::sum('bankacc'),
                'karma_sum' => A3lPlayer::sum('Karma'),
                'info' => $a3lInfo,
                'playersOnline' => $a3lPlayers,
                'restart' => $a3lRestart,
            ],
            'a3e' => [
                'account_count' => A3eAccount::count(),
                'vehicle_count' => A3eVehicle::count(),
                'territory_count' => A3eTerritory::count(),
                'money_sum' => A3eAccount::sum('money'),
                'score_sum' => A3eAccount::sum('score'),
                'kills_sum' => A3eAccount::sum('kills'),
                'deaths_sum' => A3eAccount::sum('deaths'),
                'info' => $a3eInfo,
                'playersOnline' => $a3ePlayers,
                'restart' => $a3eRestart,
            ],
            'gitlab' => [
                'issues' => [
                    'all' => $issues,
                    'open' => $issues->reject(function ($item) {
                        return $item['state'] == 'closed';
                    }),
                    'closed' => $issues->filter(function ($item) {
                        return $item['state'] == 'closed';
                    }),
                ],
            ],
            'bamboo_coins_sum' => array_sum(array_column(User::all()->toArray(), 'bamboo_coins')),
        ]);
    }
}
