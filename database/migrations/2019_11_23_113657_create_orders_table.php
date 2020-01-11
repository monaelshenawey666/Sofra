<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->string('address_delivery');
			$table->integer('resturant_id')->unsigned();
			$table->enum('state', array('pending', 'accepted', 'rejected', 'declined', 'delivered'))->default('pending');
			$table->integer('payment_method_id')->unsigned();

            $table->text('note', 65535)->nullable();
            $table->decimal('cost')->default(0.00);
            $table->decimal('delivery_cost')->default(0.00);
            $table->decimal('total')->default(0.00);
            $table->decimal('commission')->default(0.00);
            $table->decimal('net')->default(0.00);


		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
