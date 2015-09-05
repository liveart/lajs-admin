<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('ProductsTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('ColorizableelementsTableSeeder');
		$this->call('GraphicscategoriesTableSeeder');
		$this->call('GraphicsitemsTableSeeder');
		$this->call('FontsTableSeeder');
		$this->call('UserTableSeeder');
	}

}