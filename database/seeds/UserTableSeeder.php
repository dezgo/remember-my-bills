<?php
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

	public function run()
	{
		// clear table before seeding
		DB::table('users')->delete();

		$users = array(
			['id' => 1,
			 'name' => 'Derek',
			 'email' => 'derek@example.com',
			 'password' => bcrypt('password'),
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			],
			['id' => 2,
			 'name' => 'Paul',
			 'email' => 'paul@example.com',
			 'password' => bcrypt('password'),
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			]
		);

		// run the seeder
		DB::table('users')->insert($users);
	}
}
