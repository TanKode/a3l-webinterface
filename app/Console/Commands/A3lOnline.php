<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class A3lOnline extends Command
{
    protected $signature = 'a3l:online';
    protected $description = 'Checks if the A3L-Server is online.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sourceQuery = new \SourceQuery();
        $sourceQuery->Connect(env('A3L_HOST', ''), env('A3L_PORT', 2303), 1, \SourceQuery::SOURCE);
        $info = $sourceQuery->GetInfo();
        $sourceQuery->Disconnect();
        if(!$info) {
            $this->error('A3L-Server is offline.');
            \Slack::from('A3L-Server')->withIcon(':no_entry:')->send('Der Altis Life Server ist offline.');
        } else {
            $this->comment('A3L-Server is online.');
        }
    }
}
