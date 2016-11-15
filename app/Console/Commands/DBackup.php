<?php

namespace App\Console\Commands;

use App\Log;
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
        Log::artisan($this->signature);
        try {
            $connections = array_keys(config('database.connections'));
            foreach ($connections as $connection) {
                DBackupLib::tables($connection);
            }
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
        }
    }
}
