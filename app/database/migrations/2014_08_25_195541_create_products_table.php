<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('categoryId')->unsigned();
			$table->string('name');
			$table->text('description');
			$table->integer('price');
			$table->string('thumbUrl');
			$table->string('sizes')->nullable();
			$table->boolean('multicolor')->default(false);
			$table->boolean('resizable')->default(false);
			$table->boolean('showRuler')->default(false);
			$table->boolean('namesNumbersEnabled')->default(false);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}