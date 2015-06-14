<?php
use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{

	public function run()
	{
		// clear table before seeding
		DB::table('users')->delete();

		$faker = Faker::create();
		foreach(range(1, 50) as $index)
		{
			User::create([
				'name' => $faker->userName(),
				'email' => $faker->email,
				'password' => bcrypt('password'),
			]);
		}
	}
}
