<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLottoDrawsTable extends Migration
{
    public function up()
    {
        Schema::create('lottodraws', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('week')->unsigned();
            $table->integer('year')->unsigned();
            $table->string('numbers');
            $table->integer('jackpot')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lottodraws');
    }
}
