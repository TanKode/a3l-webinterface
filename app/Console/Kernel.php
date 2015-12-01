<?php namespace A3LWebInterface\Console;

use A3LWebInterface\Console\Commands\BackupDatabase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BackupDatabase::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('db:backup')->timezone(config('app.timezone'))->dailyAt('06:00');
        $schedule->command('db:backup')->timezone(config('app.timezone'))->dailyAt('18:00');
    }

}
