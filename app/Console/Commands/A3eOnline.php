<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class A3eOnline extends Command
{
    protected $signature = 'a3e:online';
    protected $description = 'Checks if the A3E-Server is online.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sourceQuery = new \SourceQuery();
        $sourceQuery->Connect(env('A3E_HOST', ''), env('A3E_PORT', 2303), 1, \SourceQuery::SOURCE);
        $info = $sourceQuery->GetInfo();
        $sourceQuery->Disconnect();
        if(!$info) {
            $this->error('A3E-Server is offline.');
            \Slack::from('A3E-Server')->withIcon(':no_entry:')->send('Der Exile Server ist offline.');
        } else {
            $this->comment('A3E-Server is online.');
        }
    }
}
