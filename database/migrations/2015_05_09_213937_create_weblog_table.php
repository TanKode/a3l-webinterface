<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateWeblogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weblog', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('editor_id')->unsigned();
            $table->string('editor_name');
            $table->integer('player_id')->unsigned()->nullable();
            $table->string('player_name');
            $table->integer('object_id')->unsigned();
            $table->string('object_name');
            $table->string('table');
            $table->string('type');
            $table->text('action')->nullable();
            $table->text('comment');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weblog');
	}

}
