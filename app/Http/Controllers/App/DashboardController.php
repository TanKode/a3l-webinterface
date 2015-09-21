<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard');
    }
}
