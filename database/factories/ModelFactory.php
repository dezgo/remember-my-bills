<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Bill::class, function ($faker) {
    $user = factory('App\User')->make();
    $account = factory('App\Account')->make();
    dd($user);
    return [
        'user_id' => $user->id,
        'description' => $faker->sentence(2),
        'last_due' => Carbon\Carbon::now(),
        'times_per_year' => $faker->numerify('##'),
        'amount' => $faker->randomFloat(2, 1, 5000),
        'dd' => $faker->numberBetween(0,1),
        'account_id' => $account->id,
    ];
});

$factory->define(App\Account::class, function ($faker) {
    return [
        'description' => $faker->word,
    ];
});
