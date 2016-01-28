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
            $this->instance = TeamSpeak3::factory('serverquery://'.config('services.teamspeak.host').':'.config('services.teamspeak.port').'/?server_port='.config('services.teamspeak.server_port').'');
            $this->info = $this->instance->getInfo();
            $this->prepareAttributes();
        } catch(\Exception $e) {
            $this->info = [];
        }
    }

    private function prepareAttributes()
    {
        $this->status = array_get($this->info, 'virtualserver_status', 'offline')->toString();
        $this->name = array_get($this->info, 'virtualserver_name')->toString();
        $this->max_clients = array_get($this->info, 'virtualserver_maxclients', 0);
        $this->host = config('services.teamspeak.host');
        $this->port = config('services.teamspeak.server_port');
    }

    public function getClients()
    {
        try {
            if(is_null($this->instance)) return null;
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