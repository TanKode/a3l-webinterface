<?php
namespace App\Http\Controllers\App;

use App\Accounting;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;

class AccountingController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage', Accounting::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        return view('app.accounting.index')->with([
            'accountings' => Accounting::all(),
            'accounting_sum' => Accounting::sum('amount'),
        ]);
    }

    public function postStore()
    {
        $data = array_filter(\Input::only('amount', 'description'));
        $validator = \Validator::make($data, Accounting::$rules);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Accounting::create([
            'booker_id' => \Auth::User()->id,
            'amount' => str_replace(',', '.', $data['amount']) * 1,
            'description' => $data['description'],
        ]);
        return redirect('app/accounting');
    }
}
