<?php
namespace App\Console;

use App\Console\Commands\A3eOnline;
use App\Console\Commands\A3eReward;
use App\Console\Commands\A3eSlots;
use App\Console\Commands\A3lOnline;
use App\Console\Commands\A3lSlots;
use App\Console\Commands\A3lTax;
use App\Console\Commands\Inspire;
use App\Console\Commands\Ts3Online;
use App\Console\Commands\Ts3Slots;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Inspire::class,

        A3lSlots::class,
        A3lOnline::class,
        A3lTax::class,

        A3eSlots::class,
        A3eOnline::class,
        A3eReward::class,

        Ts3Slots::class,
        Ts3Online::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cache:clear')->everyTenMinutes();

        $schedule->command('a3l:online')->everyFiveMinutes();
        $schedule->command('a3l:slots')->everyFiveMinutes();
        $schedule->command('a3l:tax')->dailyAt('12:00');

        $schedule->command('a3e:online')->everyFiveMinutes();
        $schedule->command('a3e:slots')->everyFiveMinutes();
        $schedule->command('a3e:reward')->monthly();

        $schedule->command('ts3:online')->everyFiveMinutes();
        $schedule->command('ts3:slots')->everyFiveMinutes();
    }
}
