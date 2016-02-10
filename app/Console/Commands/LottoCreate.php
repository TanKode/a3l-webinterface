<?php
namespace App\Console\Commands;

use App\Lotto;
use Illuminate\Console\Command;

class LottoCreate extends Command
{
    protected $signature = 'lotto:create';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $lottoDraw = new Lotto();
        $lottoDraw->week = null;
        $lottoDraw->year = null;
        $lottoDraw->numbers = null;
        $lottoDraw->jackpot = null;
        $lottoDraw->save();
    }
}
