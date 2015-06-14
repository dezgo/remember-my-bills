<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Account;

class AccountsTableSeeder extends Seeder
{

    public function run()
    {
        // clear table before seeding
        DB::table('accounts')->delete();

        $faker = Faker::create();
        $users = User::all();
        foreach($users as $user)
        {
            foreach(range(1,4) as $index1)
            {
                Account::create([
                    'user_id' => $user->id,
                    'description' => $faker->word,
                ]);
            }
        }
    }
}