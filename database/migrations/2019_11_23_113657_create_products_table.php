<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('image');
			$table->string('name');
			$table->text('description');
			$table->decimal('price');
			$table->decimal('price_in_offer');
			$table->integer('resturant_id')->unsigned();
            $table->integer('category_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}
