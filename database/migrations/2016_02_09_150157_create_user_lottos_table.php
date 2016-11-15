<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLottosTable extends Migration
{
    public function up()
    {
        Schema::create('user_lottos', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('lotto_id')->unsigned();
            $table->foreign('lotto_id')->references('id')->on('lottodraws');
            $table->string('numbers');
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_lottos');
    }
}
