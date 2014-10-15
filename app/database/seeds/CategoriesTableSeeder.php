<?php

class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('categories')->truncate();

		$categories = array(
			array('name'=>'Caps','thumbUrl'=>'zzz'),
			array('name'=>'TShirts','thumbUrl'=>'zzz'),
			array('name'=>'Signs','thumbUrl'=>'zzz'),
		);

		// Uncomment the below to run the seeder
		foreach ($categories as $cat) {
			Category::create($cat);
		}
		//DB::table('categories')->insert($categories);
	}

}

