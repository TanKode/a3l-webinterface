<?php
namespace App\Http\Controllers\App;

use App\Lotto;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LottoController extends Controller
{
    public function getIndex()
    {
        \Config::set('app.debug', true);

        $now = Carbon::now(config('app.timezone'));
        $lotto = Lotto::next()->first();
        if($now->dayOfWeek < config('a3lwebinterface.lotto.draw.new') || $now->dayOfWeek > config('a3lwebinterface.lotto.draw.day') || is_null($lotto)) {
            return view('app.lotto.closed');
        }

        if(!is_null($bet = $lotto->users()->where('id', \Auth::id())->first())) {
            return view('app.lotto.bought')->with([
                'lotto' => $lotto,
                'numbers' => explode(',', $bet->pivot->numbers),
            ]);
        }

        return view('app.lotto.index')->with([
            'lotto' => $lotto,
        ]);
    }

    public function postBet()
    {
        \Config::set('app.debug', true);

        $data = \Input::only(['number_1','number_2','number_3','number_4','number_5','number_6']);
        $validator = \Validator::make($data, [
            'number_1' => 'required|integer',
            'number_2' => 'required|integer',
            'number_3' => 'required|integer',
            'number_4' => 'required|integer',
            'number_5' => 'required|integer',
            'number_6' => 'required|integer',
        ]);
        $numbers = collect($data)->unique()->sort();
        if ($validator->fails() || $numbers->count() != 6) {
            foreach(array_diff_key($data, $numbers->toArray()) as $value) {
                $keys = array_keys(array_filter($data, function($element) use($value){
                    return isset($element) && $element == $value;
                }));
                foreach($keys as $key) {
                    $validator->messages()->add($key, trans('validation.unique', [
                        'attribute' => $value,
                    ]));
                }
            }
            return back()->withErrors($validator)->withInput();
        }

        $lotto = Lotto::next()->first();
        if(is_null($lotto)) {
            return back();
        }

        $lotto->users()->sync([
            \Auth::id() => [
                'numbers' => $numbers->implode(','),
                'created_at' => Carbon::now('UTC'),
            ]
        ], false);

        return back();
    }
}
