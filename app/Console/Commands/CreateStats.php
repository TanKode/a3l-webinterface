<?php
namespace App\Console\Commands;

use App\Statlog;
use Illuminate\Console\Command;

class CreateStats extends Command
{
    protected $signature = 'stats:create';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Statlog::newLog();
    }
}
