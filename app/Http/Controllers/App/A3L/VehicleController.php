<?php
namespace App\Http\Controllers\App\A3L;

use App\A3L\Vehicle;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function getIndex()
    {
        return view('app.a3l.vehicle.index')->with([
            'vehicles' => Vehicle::all(),
        ]);
    }

    public function getEdit($id)
    {
        return view('app.a3l.vehicle.edit')->with([
            'vehicle' => Vehicle::id($id)->firstOrFail(),
        ]);
    }
}
