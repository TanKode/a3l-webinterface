<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserSignature extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('signature')->after('password');
        });
    }

    public function down()
    {
        //
    }
}
