<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Fenos\Notifynder\Models\NotificationCategory;

class AddTaxNotification extends Migration
{
    public function up()
    {
        NotificationCategory::create([
            'name' => 'a3l.tax',
            'text' => 'Es wurden gerade **{extra.amount}** von deinem Altis Life Konto eingezogen.',
        ]);
    }

    public function down()
    {
        //
    }
}
