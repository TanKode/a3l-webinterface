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
            'a3lserver' => $this->getLife(),
        ]);
    }

    public function getTest()
    {
        \Config::set('app.debug', true);

        dd($this->getTeamspeak());

        abort(403);
    }

    protected function getLife()
    {
        try {
            $sourceQuery = new SourceQuery();
            $sourceQuery->Connect(env('A3L_HOST', ''), env('A3L_PORT', 2303), 1, SourceQuery::SOURCE);
            $a3lInfo = $sourceQuery->GetInfo();
            $a3lPlayers = collect($sourceQuery->GetPlayers());
            $sourceQuery->Disconnect();

            $now = Carbon::now()->setTimezone(config('app.timezone'));
            $restarts = collect([]);
            foreach(config('a3lwebinterface.restarts') as $time) {
                $parts = explode(':', $time);
                $carbon = Carbon::now()->setTimezone(config('app.timezone'))->setTime($parts[0], $parts[1], 0);
                $restarts->put($time, [
                    'carbon' => $carbon,
                    'diff' => $now->diffInSeconds($carbon, false),
                ]);
            }

            $a3lRestart = $restarts->reject(function($restart) {
                return $restart['diff'] <= 0;
            })->sortBy('diff')->first()['carbon'];

            return [
                'info' => $a3lInfo,
                'playersOnline' => $a3lPlayers,
                'restart' => $a3lRestart,
                'online' => true,
            ];
        } catch (\Exception $e) {
            return [
                'info' => null,
                'playersOnline' => 0,
                'restart' => null,
                'online' => false,
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
