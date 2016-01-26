<?php
namespace App\Http\Controllers\App;

use App\Player;
use App\Vehicle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function getIndex(Request $request)
    {
        $this->authorize('view', Vehicle::class);

        $player = is_null($request->get('player')) ? null : Player::findOrFail($request->get('player'));

        return view('app.vehicle.index')->with([
            'player' => $player,
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

    public function getDatatable(Request $request)
    {
        $this->authorize('view', Vehicle::class);

        $draw = $request->get('draw');
        $columns = $request->get('columns');
        $order = array_get($request->get('order'), 0);
        $search = array_get($request->get('search'), 'value');
        $start = $request->get('start');
        $length = $request->get('length');

        $vehicles = Vehicle::search($search)->orderBy(array_get($columns, array_get($order, 'column') . '.data'), array_get($order, 'dir'))->skip($start)->take($length)->get();
        $vehicles->load('owner');
        $vehicles = $vehicles->map(function ($vehicle) {
            return [
                'id' => $vehicle->getKey(),
                'pid' => $vehicle->pid,
                'side' => $vehicle->side,
                'type' => $vehicle->type,
                'name' => $vehicle->display_name,
                'classname' => $vehicle->classname,
                'alive' => $vehicle->alive,
                'active' => $vehicle->active,
                'btns' => $this->getBtnsForVehicle($vehicle),
            ];
        });
        return json_encode([
            'draw' => $draw,
            'recordsTotal' => Vehicle::count(),
            'recordsFiltered' => Vehicle::search($search)->count(),
            'data' => $vehicles,
        ]);
    }

    protected function getBtnsForVehicle($vehicle)
    {
        $out = '<div class="btn-group pull-right">';
        if (\Auth::User()->can('view', $vehicle)) $out .= '<a href="' . url('app/vehicle/' . $vehicle->getKey()) . '" class="btn btn-pure btn-icon btn-success"><i class="icon wh-eye-view"></i></a>';
        if (\Auth::User()->can('edit', $vehicle)) $out .= '<a href="' . url('app/vehicle/edit/' . $vehicle->getKey()) . '" class="btn btn-pure btn-icon btn-warning"><i class="icon wh-edit"></i></a>';
        if (\Auth::User()->can('delete', $vehicle)) $out .= '<a href="' . url('app/vehicle/delete/' . $vehicle->getKey()) . '" class="btn btn-pure btn-icon btn-danger"><i class="icon wh-trash"></i></a>';
        if (\Auth::User()->can('view', $vehicle->owner)) $out .= '<a href="' . url('app/player/' . $vehicle->owner->getKey()) . '" class="btn btn-pure btn-icon btn-success"><i class="icon wh-boardgame"></i></a>';
        $out .= '</div>';
        return $out;
    }
}
