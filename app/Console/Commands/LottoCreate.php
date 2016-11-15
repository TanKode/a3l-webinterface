<?php
namespace App\Console\Commands;

use App\Lotto;

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
        $this->comment('create new Looto draw');
        $lottoDraw = new Lotto();
        $lottoDraw->week = null;
        $lottoDraw->year = null;
        $lottoDraw->numbers = null;
        $lottoDraw->jackpot = null;
        $lottoDraw->save();
        $this->info('created new Lotto draw for ' . $lottoDraw->week . '@' . $lottoDraw->year . ' with ' . \Formatter::money($lottoDraw->jackpot) . ' jackpot & numbers: ' . $lottoDraw->numbers);
    }
}
