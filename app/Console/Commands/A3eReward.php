<?php
namespace App\Console\Commands;

use App\A3E\Account;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Riari\Forum\Models\Post;

class A3eReward extends Command
{
    protected $signature = 'a3e:reward';
    protected $description = 'Rewards the best KD-Players with Bamboo-Coins.';
    private $excluded = [
        '76561198061912622', // Tom
        '76561198070524133', // Fabi
    ];
    private $maxUsers = 3;
    private $minKd = 2;
    private $minReward = 5;
    private $reward = 2;
    private $maxReward = 25;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $accounts = Account::orderBy(DB::raw('kills / deaths'), 'desc')->get();
        $i = 0;
        $lastKd = 0;
        $rewarded = [];
        foreach($accounts as $account) {
            if(in_array($account->uid, $this->excluded)) continue;
            if($account->kd < $this->minKd) continue;
            if($i >= $this->maxUsers && $account->kd < $lastKd) continue;
            $lastKd = $account->kd;
            $user = User::steam($account->uid)->first();
            if(is_null($user)) continue;

            $reward = round($account->kd * $this->reward);
            $reward = $reward < $this->minReward ? $this->minReward : $reward;
            $reward = $reward > $this->maxReward ? $this->maxReward : $reward;
            $user->addBambooCoins($reward);
            $rewarded[] = $user;
            $i++;
        }
        $now = Carbon::now();
        $content = 'Die Gewinner des KD-Highscores im '.$now->formatLocalized('%B') . ' ' . $now->year . ' sind:' . PHP_EOL . PHP_EOL;
        foreach($rewarded as $user) {
            $content .= '+ **' . $user->username . '** (_' . $user->a3eAccount()->name . '_) KD: ' . round($user->a3eAccount()->kd, 2) . PHP_EOL;
        }

        \Slack::from('A3E-Server')->to('#exile')->withIcon(':gift:')->send(str_replace('**', '*', $content));

        $post = [
            'parent_thread' => 5,
            'author_id'     => 1,
            'content'       => $content,
        ];
        $post = Post::create($post);
        $post->thread->touch();
    }
}
