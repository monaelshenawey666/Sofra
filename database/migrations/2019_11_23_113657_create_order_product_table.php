<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductTable extends Migration {

	public function up()
	{
		Schema::create('order_product', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			//$table->string('special_order');
			$table->integer('quantity');
			//$table->decimal('total_cost');
			$table->integer('product_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('resturant_id')->unsigned();
			$table->decimal('price');
            $table->text('note', 65535)->nullable();

        });
	}

	public function down()
	{
		Schema::drop('order_product');
	}
}
