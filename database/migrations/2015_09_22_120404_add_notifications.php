<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Fenos\Notifynder\Models\NotificationCategory;

class AddNotifications extends Migration
{
    protected $categories = [
        [
            'name' => 'user.create',
            'text' => 'Es hat sich ein neuer Benutzer registriert - **{from.username}**.',
        ],[
            'name' => 'user.role',
            'text' => 'Deine Benutzerrolle wurde von **{extra.role_before}** zu **{extra.role_after}** verändert.',
        ],[
            'name' => 'coins.added',
            'text' => 'Deinem Account wurden **{extra.bamboo_amount}** Bamboo-Coins gutgeschrieben.',
        ],
    ];

    public function up()
    {
        foreach($this->categories as $category) {
            NotificationCategory::create($category);
        }
    }

    public function down()
    {
        //
    }
}
