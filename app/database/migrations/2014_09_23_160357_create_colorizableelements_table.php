<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateColorizableelementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('colorizableElements', function(Blueprint $table) {
			$table->increments('id');
			$table->string('css_id');
			$table->string('name');
			$table->integer('of_id');
			$table->string('of_type');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('colorizableElements');
	}

}
