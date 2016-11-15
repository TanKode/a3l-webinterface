<?php
namespace App\Console\Commands;

use App\Log;
use Illuminate\Console\Command;

class A3eSlots extends Command
{
    protected $signature = 'a3e:slots';
    protected $description = 'Checks if the A3E-Server is full.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::artisan($this->signature);
        $sourceQuery = new \SourceQuery();
        $sourceQuery->Connect(env('A3E_HOST', ''), env('A3E_PORT', 2303), 1, \SourceQuery::SOURCE);
        $info = $sourceQuery->GetInfo();
        $sourceQuery->Disconnect();
        if($info) {
            if ($info['Players'] == $info['MaxPlayers']) {
                $this->error('A3E-Server is full.');
                \Slack::from('A3E-Server')->withIcon(':no_entry:')->send('Der Exile Server ist voll.');
            } elseif ($info['Players'] >= $info['MaxPlayers'] * 0.9) {
                $this->error('A3E-Server is nearly full.');
                \Slack::from('A3E-Server')->withIcon(':no_entry:')->send('Der Exile Server ist fast voll.');
            } else {
                $this->error('A3E-Server is open.');
            }
        }
    }
}
