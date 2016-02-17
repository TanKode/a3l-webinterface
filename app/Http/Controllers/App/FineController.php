<?php
namespace App\Http\Controllers\App;

use App\Lotto;
use App\Statlog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FineController extends Controller
{
    public function getWanted()
    {
        $wanteds = \Formatter::decodeDBArray(\DB::connection('arma')->table('wanted')->first()->list);

        return view('app.fine.wanted')->with([
            'wanteds' => $wanteds,
        ]);
    }

    public function getCalculator()
    {
        $fines = collect(config('a3l.fines'))->map(function ($fines) {
            return array_combine(array_keys($fines), array_keys($fines));
        });

        return view('app.fine.calculator')->with([
            'fines' => $fines->toArray(),
            'calculation' => \Session::get('calculation'),
        ]);
    }

    public function postCalculator()
    {
        $results = [
            'data' => [],
            'min' => 0,
            'max' => 0,
            'prison' => 0,
        ];
        foreach (config('a3l.fines') as $fines) {
            foreach ($fines as $key => $fine) {
                if (in_array($key, \Input::get('fines'))) {
                    $results['data'][$key] = $fine;
                    $results['min'] += array_get($fine, 'min', 0);
                    $results['max'] += array_get($fine, 'max', 0);
                    $results['prison'] += array_get($fine, 'prison', 0);
                }
            }
        }

        return redirect()->to('app/fine/calculator')->with([
            'calculation' => $results,
        ]);
    }
}
