<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BackupDatabase;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        BackupDatabase::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('db:backup')->timezone(config('app.timezone'))->dailyAt('06:00');
        $schedule->command('db:backup')->timezone(config('app.timezone'))->dailyAt('18:00');
    }
}
