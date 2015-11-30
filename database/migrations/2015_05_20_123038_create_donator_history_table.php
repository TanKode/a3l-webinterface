<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonatorHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('donator_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('editor_id')->unsigned();
			$table->string('editor_name');
			$table->string('player_id', 50);
			$table->string('player_name');
			$table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('amount')->unsigned();
			$table->integer('duration')->unsigned();
			$table->string('method');
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
		Schema::drop('donator_history');
	}

}
