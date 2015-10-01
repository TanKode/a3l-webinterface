<?php
namespace App\Teamspeak;

use Illuminate\Support\Collection;
use TeamSpeak3\TeamSpeak3;

class Server extends Model
{
    private $instance;

    public function __construct()
    {
        try {
            $this->instance = TeamSpeak3::factory('serverquery://'.config('services.teamspeak.user').':'.config('services.teamspeak.password').'@'.config('services.teamspeak.host').':'.config('services.teamspeak.port').'/?server_port='.config('services.teamspeak.server_port').'');
            $this->info = $this->instance->getInfo();
        } catch(\Exception $e) {
            $this->info = [];
        }
        $this->prepareAttributes();
    }

    private function prepareAttributes()
    {
        $this->status = array_get($this->info, 'virtualserver_status', 'offline')->toString();
        $this->name = array_get($this->info, 'virtualserver_name')->toString();
        $this->cur_clients = array_get($this->info, 'virtualserver_client_connections', 0);
        $this->max_clients = array_get($this->info, 'virtualserver_maxclients', 0);
        $this->host = config('services.teamspeak.host');
        $this->port = config('services.teamspeak.server_port');
    }

    public function getClients()
    {
        try {
            $clientList = $this->instance->clientList();
            $clients = new Collection();
            foreach ($clientList as $client) {
                if ($client['client_type']) continue;
                $clients->push(new Client($client->getInfo(), $this));
            }
            return $clients;
        } catch(\Exception $e) {
            return null;
        }
    }
}