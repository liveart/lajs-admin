<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('Users')->truncate();

        $user = new User;
		$user->name = 'Default Admin';
        $user->username = 'admin';
        $user->email = 'admin@liveartdesigner.com';
        $user->password = Hash::make('l1v34rt');

		$user->save();
	}

}
