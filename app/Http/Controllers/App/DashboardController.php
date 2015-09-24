<?php
namespace App\Http\Controllers\App;

use App\Accounting;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard')->with([
            'accounting_sum' => Accounting::sum('amount'),
            'bamboo_coins_sum' => array_sum(array_column(User::all()->toArray(), 'bamboo_coins')),
        ]);
    }
}
