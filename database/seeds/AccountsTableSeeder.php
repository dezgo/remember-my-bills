<?php
use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{

    public function run()
    {
        // clear table before seeding
        DB::table('accounts')->delete();

        $accounts = array(
            ['id' => 1,
             'user_id' => 1,
             'description' => 'Credit-D',
             'created_at' => \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()
            ],
            ['id' => 2,
             'user_id' => 1,
             'description' => 'Savings-D',
             'created_at' => \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()
            ],
            ['id' => 3,
             'user_id' => 1,
             'description' => 'Cheque-D',
             'created_at' => \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()
            ],
            ['id' => 4,
             'user_id' => 2,
             'description' => 'Credit-P',
             'created_at' => \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()
            ],
            ['id' => 5,
              'user_id' => 2,
              'description' => 'Savings-P',
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now()
            ],
            ['id' => 6,
             'user_id' => 2,
             'description' => 'Cheque-P',
             'created_at' => \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()
            ]
        );

        // run the seeder
        DB::table('accounts')->insert($accounts);
    }
}