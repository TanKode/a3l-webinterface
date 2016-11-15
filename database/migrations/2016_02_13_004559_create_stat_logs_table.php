<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatLogsTable extends Migration
{
    public function up()
    {
        Schema::create('statlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_count')->unsigned();
            $table->integer('cop_count')->unsigned();
            $table->integer('medic_count')->unsigned();
            $table->integer('atac_count')->unsigned();
            $table->integer('player_money')->unsigned();
            $table->integer('vehicle_count')->unsigned();
            $table->integer('gang_count')->unsigned();
            $table->integer('gang_money')->unsigned();
            $table->integer('user_count')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('statlogs');
    }
}
