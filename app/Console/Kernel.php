<?php
namespace App\Console;

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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\A3lOnline::class,
        \App\Console\Commands\A3lSlots::class,
        \App\Console\Commands\A3eOnline::class,
        \App\Console\Commands\A3eSlots::class,
        \App\Console\Commands\Ts3Online::class,
        \App\Console\Commands\Ts3Slots::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('a3l:online')->everyFiveMinutes();
        $schedule->command('a3l:slots')->everyFiveMinutes();
        $schedule->command('a3e:online')->everyFiveMinutes();
        $schedule->command('a3e:slots')->everyFiveMinutes();
        $schedule->command('ts3:online')->everyFiveMinutes();
        $schedule->command('ts3:slots')->everyFiveMinutes();
    }
}
