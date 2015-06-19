<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

/**
 * Class PaymentsTableSeeder
 */
class PaymentsTableSeeder extends Seeder {

    /**
     * Run the payment seeder
     */
    public function run()
    {
        // clear table before seeding
        DB::table('payments')->delete();

        $faker = Faker::create();
        $users = User::all();
        foreach($users as $user)
        {
            $accounts = $user->accounts()->lists('id')->toArray();
            foreach(range(1,20) as $payment)
            {
                $account = $faker->randomElement($accounts);
                factory('App\Payment')->create([
                    'user_id' => $user->id,
                    'account_id' => $account,
                ]);
            }
        }
    }
}
