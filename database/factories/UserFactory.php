<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\ja_JP\Person($faker));
    $faker->addProvider(new \Faker\Provider\ja_JP\Address($faker));
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'role_id' => \App\Role::where('type', '!=', 'admin')->inRandomOrder()->first()->id,
        'status' => true,
        'office_id' => \App\Office::create(['name' => $faker->streetName ])->id,
        'password' => 'password', // password
        'remember_token' => Str::random(10),
    ];
});
