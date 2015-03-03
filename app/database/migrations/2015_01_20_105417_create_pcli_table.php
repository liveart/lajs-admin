<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePcliTable extends Migration {

	/**
	 * Product Color Location Images - PCLI
	 * Stands for indicating a relation between image and certain Location/Color combination
	 * for certain product. Used for one image per color type of products.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pclis', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('color_id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->string('image');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pclis');
	}

}
