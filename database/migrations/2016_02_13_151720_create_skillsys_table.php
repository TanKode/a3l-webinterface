<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsysTable extends Migration
{
    public function up()
    {
        Schema::connection('arma')->create('skillsys', function (Blueprint $table) {
            $table->string('playerid');
            foreach (\App\Skillsys::$skills as $skill) {
                $table->integer(str_slug('skill_'.$skill, '_'))->default(0);
            }
            $table->timestamps();
            $table->primary('playerid');
        });

        foreach (\App\Player::all() as $player) {
            \App\Skillsys::create([
                'playerid' => $player->playerid,
            ]);
        }
    }

    public function down()
    {
        Schema::connection('arma')->dropIfExists('skillsys');
    }
}
