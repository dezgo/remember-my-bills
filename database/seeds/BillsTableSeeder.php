<?php
use Illuminate\Database\Seeder;

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

		$bills = array(
			['id' => 1,
			 'user_id' => 1,
			 'description' => 'Mobile phone D',
			 'last_due' => \Carbon\Carbon::now()->subDays(45),
			 'times_per_year' => 12,
			 'amount' => 30.0,
			 'account_id' => 1,
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			],
			['id' => 2,
			 'user_id' => 1,
			 'description' => 'Electricity D',
			 'last_due' => \Carbon\Carbon::now()->addDays(-50),
			 'times_per_year' => 4,
			 'amount' => 350.0,
			 'account_id' => 2,
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			],
			['id' => 3,
			 'user_id' => 1,
			 'description' => 'Child Sponsorship D',
			 'last_due' => \Carbon\Carbon::now()->addDays(-20),
			 'times_per_year' => 12,
			 'amount' => 45.0,
			 'account_id' => 3,
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			],
			['id' => 4,
			 'user_id' => 2,
			 'description' => 'Mobile phone P',
			 'last_due' => \Carbon\Carbon::now()->subDays(45),
			 'times_per_year' => 12,
			 'amount' => 30.0,
			 'account_id' => 4,
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			],
			['id' => 5,
			 'user_id' => 2,
			 'description' => 'Electricity P',
			 'last_due' => \Carbon\Carbon::now()->addDays(-50),
			 'times_per_year' => 4,
			 'amount' => 350.0,
			 'account_id' => 5,
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			],
			['id' => 6,
			 'user_id' => 2,
			 'description' => 'Child Sponsorship P',
			 'last_due' => \Carbon\Carbon::now()->addDays(-20),
			 'times_per_year' => 12,
			 'amount' => 45.0,
			 'account_id' => 6,
			 'created_at' => \Carbon\Carbon::now(),
			 'updated_at' => \Carbon\Carbon::now()
			]
		);

		// run the seeder
		DB::table('bills')->insert($bills);
	}
}
