<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVehicleInsured extends Migration
{
    public function up()
    {
        Schema::connection('arma')->table('vehicles', function (Blueprint $table) {
            $table->boolean('insured')->default(0);
            $table->timestamp('insured_at')->nullable();
        });
    }

    public function down()
    {
        Schema::connection('arma')->table('vehicles', function (Blueprint $table) {
            $table->dropColumn('insured');
            $table->dropColumn('insured_at');
        });
    }
}
