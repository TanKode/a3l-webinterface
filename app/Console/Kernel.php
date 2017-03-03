<?php

namespace App\Console;

use Carbon\Carbon;
use App\Console\Commands\LottoDraw;
use App\Console\Commands\CreateStats;
use App\Console\Commands\LottoCreate;
use App\Console\Commands\CarInsurance;
use App\Console\Commands\BackupDatabase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('bouncer:seed')->everyThirtyMinutes();
    }
}
