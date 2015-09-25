<?php
namespace App\Http\Controllers\App;

use App\A3L\Player as A3lPlayer;
use App\Accounting;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getIndex()
    {
        $sourceQuery = new \SourceQuery();
        $sourceQuery->Connect(env('A3L_HOST', ''), env('A3L_PORT', 2303), 1, \SourceQuery::SOURCE);
        $a3lInfo = $sourceQuery->GetInfo();
        $a3lPlayers = $sourceQuery->GetPlayers();
        $sourceQuery->Disconnect();

        $restart = Carbon::now()->setTimezone('Europe/Berlin');
        $restart->minute = 0;
        $restart->second = 0;
        $restart->addHours((ceil($restart->hour / 6) * 6) - $restart->hour);

        return view('app.dashboard')->with([
            'accounting_sum' => Accounting::sum('amount'),
            'a3l' => [
                'player_count' => A3lPlayer::count(),
                'money_sum' => A3lPlayer::sum('cash') + A3lPlayer::sum('bankacc'),
                'karma_sum' => A3lPlayer::sum('Karma'),
                'info' => $a3lInfo,
                'playersOnline' => $a3lPlayers,
                'restart' => $restart,
            ],
            'bamboo_coins_sum' => array_sum(array_column(User::all()->toArray(), 'bamboo_coins')),
        ]);
    }
}
