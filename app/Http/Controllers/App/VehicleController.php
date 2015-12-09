<?php
namespace App\Http\Controllers\App;

use App\Player;
use App\Vehicle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function getIndex()
    {
        $this->authorize('view', Vehicle::class);

        return view('app.vehicle.index')->with([
            'vehicles' => Vehicle::all(),
        ]);
    }

    public function getShow(Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        return view('app.vehicle.single')->with([
            'vehicle' => $vehicle,
            'readonly' => true,
        ]);
    }

    public function getEdit(Vehicle $vehicle)
    {
        $this->authorize('edit', $vehicle);

        return view('app.vehicle.single')->with([
            'vehicle' => $vehicle,
            'readonly' => false,
        ]);
    }

    public function postEdit(Vehicle $vehicle)
    {
        $this->authorize('edit', $vehicle);

        $data = \Input::all();
        $validator = \Validator::make($data, Vehicle::$rules['update']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vehicle->update($data);
        return redirect('app/vehicle/edit/' . $vehicle->getKey());
    }

    public function getDelete(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);
        $vehicle->delete();
        return redirect('app/vehicle');
    }
}
