<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tokens', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('accountable_id');
			$table->string('accountable_type');
			$table->string('token');
			$table->enum('type', array('android','ios'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tokens');
	}

}
