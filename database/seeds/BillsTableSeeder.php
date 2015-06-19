<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Bill;
use App\Account;

/**
 * Class BillsTableSeeder
 */
class BillsTableSeeder extends Seeder {

	/**
	 * Run the bill seeder
	 */
	public function run()
	{
		// clear table before seeding
		DB::table('bills')->delete();

		$faker = Faker::create();
		$users = User::all();
		foreach($users as $user)
		{
			$accounts = $user->accounts()->lists('id')->toArray();
            foreach(range(1,20) as $bill)
            {
                $account = $faker->randomElement($accounts);
                factory('App\Bill')->create([
                    'user_id' => $user->id,
                    'account_id' => $account,
                ]);
            }
		}
	}
}
