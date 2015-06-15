<?php
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

	public function run()
	{
		// clear table before seeding
		DB::table('users')->delete();

		// and see using model factory
		$user = factory('App\User', 50)->create();
	}
}
