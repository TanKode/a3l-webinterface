<?php

namespace App\Console\Commands;

use App\Vehicle;

class CarInsurance extends Command
{
    protected $signature = 'insurance:car';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->comment('do insurance:car');
        $destroyedInsuredVehicles = Vehicle::destroyed()->insured()->get();
        foreach ($destroyedInsuredVehicles as $vehicle) {
            $this->info('do insurance:car for vehicle#'.$vehicle->getKey().' of '.$vehicle->owner->playerid);
            $vehicle->useInsurance();
        }
    }
}
