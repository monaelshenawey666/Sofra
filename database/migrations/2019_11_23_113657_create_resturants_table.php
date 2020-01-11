<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResturantsTable extends Migration {

	public function up()
	{
		Schema::create('resturants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->string('pin_code');
			$table->integer('region_id')->unsigned();
			$table->float('delivery_fee')->default(0.00);;
			$table->string('whatsNum');
			$table->string('delivery_phone');
			$table->integer('mini');
			$table->string('image');
			$table->string('time_of_preparation');
            $table->enum('availability', array('open','closed'));

        });
	}

	public function down()
	{
		Schema::drop('resturants');
	}
}
