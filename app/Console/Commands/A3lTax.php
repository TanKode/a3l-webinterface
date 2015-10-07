<?php

namespace App\Console\Commands;

use App\A3L\Player;
use Illuminate\Console\Command;

class A3lTax extends Command
{
    protected $signature = 'a3l:tax';
    protected $description = 'Calculates the tax for all players on the A3L-Server.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $players = Player::lastDay()->get();
        $tax = 0;
        foreach($players as $player) {
            if(($player->cash + $player->bankacc) < 10000) continue;
            $taxCach = $player->cash * 0.05;
            $taxBank = $player->bankacc * 0.05;
            $tax += $taxCach;
            $tax += $taxBank;
            $player->cash -= $taxCach;
            $player->bankacc -= $taxBank;
            $player->save();
        }
        \Slack::from('A3L-Server')->to('#altis-life')->withIcon(':moneybag:')->send('Es wurden gerade ' . format_money($tax) . ' an Steuern auf dem Altis Life Server eingezogen.');
    }
}
