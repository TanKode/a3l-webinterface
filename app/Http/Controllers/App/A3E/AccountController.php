<?php
namespace App\Http\Controllers\App\A3E;

use App\A3E\Account;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function getIndex()
    {
        return view('app.a3e.account.index')->with([
            'accounts' => Account::all(),
        ]);
    }
}
