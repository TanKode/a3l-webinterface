<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailConfirmation extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_token');
        });

        foreach(\App\User::all() as $user) {
            $user->confirmation_token = str_random(32);
            $user->save();
            \Mail::send('emails.verification', [
                'user' => $user,
            ], function ($m) use ($user) {
                $m->from('noreply@gummibeer.de', trans('messages.title'));
                $m->to($user->email, $user->name)->subject('E-Mail verification.');
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('confirmed');
            $table->dropColumn('confirmation_token');
        });
    }
}
