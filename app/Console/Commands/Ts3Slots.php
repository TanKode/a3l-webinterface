<?php
namespace App\Console\Commands;

use App\Teamspeak\Server;
use Illuminate\Console\Command;

class Ts3Slots extends Command
{
    protected $signature = 'ts3:slots';
    protected $description = 'Checks if the TS3-Server is full.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $server = new Server();
        if($server->getClients()->count() == $server->max_clients) {
            $this->error('TS3-Server is full.');
            \Slack::from('TS3-Server')->withIcon(':no_entry:')->send('Der TeamSpeak 3 Server ist voll.');
        } elseif($server->getClients()->count() >= $server->max_clients * 0.9) {
            $this->error('TS3-Server is nearly full.');
            \Slack::from('TS3-Server')->withIcon(':no_entry:')->send('Der TeamSpeak 3 Server ist fast voll.');
        } else {
            $this->error('TS3-Server is open.');
        }
    }
}
