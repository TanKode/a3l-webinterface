<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForumReplyNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Fenos\Notifynder\Models\NotificationCategory::create([
            'name' => 'forum.reply',
            'text' => '**{from.username}** hat im Forum eine Antwort hinterlassen.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
