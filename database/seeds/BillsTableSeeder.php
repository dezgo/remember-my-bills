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
		$times_per_year = [1, 2, 3, 4, 6, 12, 24, 52, 365];
		foreach($users as $user)
		{
			$accounts = $user->accounts()->lists('id')->toArray();
			foreach(range(1,20) as $index1)
			{
				Bill::create([
					'user_id' => $user->id,
					'description' => $faker->sentence(2),
					'last_due' => Carbon\Carbon::now()->subDays($faker->numberBetween(0,60)),
					'times_per_year' => $faker->randomElement($times_per_year),
					'amount' => $faker->randomFloat(2, 1, 5000),
					'dd' => $faker->numberBetween(0,1),
					'account_id' => $faker->randomElement($accounts)
				]);
			}
		}
	}
}
