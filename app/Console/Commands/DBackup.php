<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libs\DBackup as DBackupLib;

class DBackup extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backups all configured databases.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $connections = array_keys(config('database.connections'));
        foreach($connections as $connection) {
            DBackupLib::tables($connection);
        }
    }
}
