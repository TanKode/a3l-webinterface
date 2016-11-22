<?php

namespace App\Http\Controllers\App;

use App\Lotto;
use App\Player;
use App\Statlog;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard.index')->with([
            'dynmarket' => collect(json_decode(\DB::connection('arma')->table('dynmarket')->first()->prices))->unique(0)->sortByDesc(1),
            'a3lserver' => $this->getLife(),
            'ts3server' => $this->getTeamspeak(),
            'lotto' => Lotto::next()->first(),
            'statlogs' => Statlog::orderBy('created_at', 'desc')->take(28)->get(),
            'post' => array_get(wp_get_recent_posts([
                'numberposts' => 1,
            ], OBJECT), 0),
        ]);
    }

    public function getTest()
    {
        \Config::set('app.debug', true);

        $player = Player::find(179);
        dump($player);
        foreach ($player->revisionHistory()->orderBy('created_at', 'desc')->limit(100)->get() as $history) {
            $field = $history->fieldName();
            $old = $history->old_value;
            $new = $history->new_value;
            if (is_numeric($history->new_value) && is_numeric($history->old_value)) {
                $type = 'numeric';
                $old *= 1;
                $new *= 1;
                $diff = $new - $old;
            } elseif (str_contains($field, 'licenses')) {
                $type = 'array';
                $old = \Formatter::decodeDBArray($old);
                $new = \Formatter::decodeDBArray($new);
                $old = array_combine(array_column($old, 0), array_column($old, 1));
                $new = array_combine(array_column($new, 0), array_column($new, 1));
                $diff = array_diff_assoc($new, $old);
            } else {
                $type = 'string';
                $diff = null;
            }
            dump([
                'field' => $history->fieldName(),
                'old' => $old,
                'new' => $new,
                'diff' => $diff,
                'type' => $type,
            ]);
        }

        dd(true);

        abort(403);
    }
}
