<?php
namespace App\Console;

use App\Console\Commands\LottoCreate;
use App\Console\Commands\LottoDraw;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BackupDatabase;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        BackupDatabase::class,
        LottoDraw::class,
        LottoCreate::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        foreach (config('a3lwebinterface.restarts') as $restart) {
            $schedule->command('db:backup')->timezone(config('app.timezone'))->dailyAt($restart);
        }
        $schedule->command('bouncer:seed')->everyThirtyMinutes();

        $schedule->command('lotto:draw')->timezone(config('app.timezone'))->dailyAt(config('a3lwebinterface.lotto.time'))->when(function () {
            return Carbon::now(config('app.timezone'))->dayOfWeek === config('a3lwebinterface.lotto.draw.day');
        });
        $schedule->command('lotto:create')->timezone(config('app.timezone'))->dailyAt(config('a3lwebinterface.lotto.time'))->when(function () {
            return Carbon::now(config('app.timezone'))->dayOfWeek === config('a3lwebinterface.lotto.draw.new');
        });
    }
}
