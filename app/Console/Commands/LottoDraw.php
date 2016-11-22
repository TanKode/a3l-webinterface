<?php

namespace App\Console\Commands;

use App\Lotto;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LottoDraw extends Command
{
    protected $signature = 'lotto:draw';

    protected $description = 'Simulates a Lotto draw and gives all the profits.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('start lotto draw');
        $lottoDraw = Lotto::last()->first();
        if (is_null($lottoDraw)) {
            $this->error('no lotto draw exists');
            throw (new ModelNotFoundException)->setModel(Lotto::class);
        }
        $this->comment('numbers: '.$lottoDraw->numbers);
        $this->comment('jackpot: '.\Formatter::money($lottoDraw->jackpot));
        $this->comment('draw: '.$lottoDraw->week.' @ '.$lottoDraw->year);

        foreach ($lottoDraw->users as $user) {
            if ($user->hasPlayer()) {
                $player = $user->player;
                if ($player->bankacc >= config('a3lwebinterface.lotto.cost')) {
                    $correct = $lottoDraw->getCorrectsByNumbers($user->pivot->numbers);
                    $profit = $lottoDraw->getProfitByNumbers($user->pivot->numbers);
                    $player->bankacc -= config('a3lwebinterface.lotto.cost');
                    $player->bankacc += $profit;
                    $player->save();

                    $this->comment('User#'.$user->getKey().'(Player#'.$player->getKey().') wins '.\Formatter::money($profit).' with '.$correct.' correct numbers');

                    if ($profit > 0) {
                        \Notify::category('lotto.won')
                            ->from(0)
                            ->to($user->getKey())
                            ->url('#')
                            ->extra([
                                'correct' => $correct,
                                'profit' => \Formatter::money($profit),
                            ])
                            ->send();
                    } else {
                        \Notify::category('lotto.lost')
                            ->from(0)
                            ->to($user->getKey())
                            ->url('#')
                            ->extra(compact('correct'))
                            ->send();
                    }
                }
            }
        }
    }
}
