<?php

class VehiclesController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postEdit() {
        $rules = array(
            'vehicleid'=>'required|numeric|exists:vehicles,id',
            'playerid'=>'required|numeric|exists:players,playerid'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes() && Auth::user()->canEditVehicle(Input::get('playerid'))) {
            $alive = 0;
            if(Input::get('alive') == 1)
                $alive = 1;

            $active = 0;
            if(Input::get('active') == 1)
                $active = 1;

            $delete = 0;
            if(Input::get('delete') == 1)
                $delete = 1;

            if($delete) {
                DB::table('vehicles')->where('id', Input::get('vehicleid'))->delete();
            } else {
                $vehicle = Vehicle::find(Input::get('vehicleid'));
                $vehicle->alive = $alive;
                $vehicle->active = $active;
                $vehicle->save();
            }

            return Redirect::to('/vehicles')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } else {
            return Redirect::to('/vehicles')
                ->with(array('message'=>'Leider ist ein Fehler aufgetreten, die Änderung wurde verworfen.', 'type' => 'danger'));
        }
    }
}