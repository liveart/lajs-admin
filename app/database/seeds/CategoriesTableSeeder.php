<?php

class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('categories')->truncate();

		$categories = array(
			array(
				'name'=>'TShirts',
				'thumbUrl'=>'zzz',
				'updated_at'=>DB::raw('datetime("now")'),
				'created_at'=>DB::raw('datetime("now")')
				)
		);

		// Uncomment the below to run the seeder
		DB::table('categories')->insert($categories);
	}

}
