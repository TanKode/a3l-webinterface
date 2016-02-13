<?php
namespace App\Console\Commands;

use App\Vehicle;
use Illuminate\Console\Command;

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
        $destroyedInsuredVehicles = Vehicle::destroyed()->insured()->get();
        foreach($destroyedInsuredVehicles as $vehicle) {
            $vehicle->useInsurance();
        }
    }
}
