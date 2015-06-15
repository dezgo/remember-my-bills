<?php
use Illuminate\Database\Seeder;
use App\User;

class AccountsTableSeeder extends Seeder
{

    public function run()
    {
        // clear table before seeding
        DB::table('accounts')->delete();

        $users = User::all();
        foreach($users as $user)
        {
            factory('App\Account',4)->create(['user_id' => $user->id]);
        }
    }
}