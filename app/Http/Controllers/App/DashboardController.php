<?php
namespace App\Http\Controllers\App;

use App\Teamspeak\Server;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use xPaw\SourceQuery\SourceQuery;

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

        dd($this->getLife());

        abort(403);
    }

    protected function getLife()
    {
        try {
            $sourceQuery = new SourceQuery();
            $sourceQuery->Connect(env('A3L_HOST', ''), env('A3L_PORT', 2302), 1, SourceQuery::SOURCE);
            $a3lInfo = $sourceQuery->GetInfo();
            dd($a3lInfo);
            $a3lPlayers = collect($sourceQuery->GetPlayers());
            $sourceQuery->Disconnect();

            $a3lRestart = Carbon::now()->setTimezone('Europe/Berlin');
            $a3lRestart->minute = 0;
            $a3lRestart->second = 0;
            $hours = (ceil($a3lRestart->hour / 6) * 6) - $a3lRestart->hour;
            $hours = $hours == 0 ? 6 : $hours;
            $a3lRestart->addHours($hours);

            return [
                'info' => $a3lInfo,
                'playersOnline' => $a3lPlayers,
                'restart' => $a3lRestart,
            ];
        } catch (\Exception $e) {
            return [
                'info' => null,
                'playersOnline' => 0,
                'restart' => null,
            ];
        }
    }

    protected function getTeamspeak()
    {
        $server = new Server();
        $clients = $server->getClients();
        return [
            'server' => $server,
            'clients' => $clients,
        ];
    }
}
