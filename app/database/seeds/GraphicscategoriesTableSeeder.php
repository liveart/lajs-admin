<?php

class GraphicscategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('graphicscategories')->truncate();

		$graphicscategories = array(
			array('name'=>'Animals'),
			array('name'=>'Icons'),
			array('name'=>'Vehicles')
		);

		// Uncomment the below to run the seeder
		DB::table('graphicscategories')->insert($graphicscategories);
	}

}
