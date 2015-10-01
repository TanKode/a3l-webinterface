<?php
namespace App\Console\Commands;

use App\Teamspeak\Server;
use Illuminate\Console\Command;

class Ts3Online extends Command
{
    protected $signature = 'ts3:online';
    protected $description = 'Checks if the TS3-Server is online.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $server = new Server();
        if($server->status != 'online') {
            $this->error('TS3-Server is offline.');
            \Slack::from('TS3-Server')->withIcon(':no_entry:')->send('Der TeamSpeak 3 Server ist offline.');
        } else {
            $this->comment('TeamSpeak 3 Server is online.');
        }
    }
}
