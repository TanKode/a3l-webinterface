<?php
namespace App\Http\Controllers;

use App\Teamspeak\Server;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use xPaw\SourceQuery\SourceQuery;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
                    'diff' => $now->diffInSeconds($carbon, false) > 0 ? $now->diffInSeconds($carbon, false) : $now->diffInSeconds($carbon->addDay(), false),
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
