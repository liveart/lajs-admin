<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFontsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fonts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('fontFamily');
			$table->integer('ascent');
			$table->string('vector');
			$table->boolean('boldAllowed')->default(true);
			$table->boolean('italicAllowed')->default(true);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fonts');
	}

}
