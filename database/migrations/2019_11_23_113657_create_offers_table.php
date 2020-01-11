<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('image');
			$table->string('name');
			$table->text('description');
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('resturant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}