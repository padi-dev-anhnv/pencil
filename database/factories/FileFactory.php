<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\ja_JP\Person($faker));
    $faker->addProvider(new \Faker\Provider\ja_JP\Address($faker));
    $faker->addProvider(new \Faker\Provider\ja_JP\Text($faker));
    $randomUser = App\User::whereHas('role', function($query){
        $query->whereIn('type', ['admin', 'file_manager', 'instruction_manager']);
    })->inRandomOrder()->first();

    $arrayFile = [
        ['type' => 'jpg', 'total' => 67],
        ['type' => 'psd', 'total'  => 7],
        ['type' => 'ai', 'total'   => 5],
        ['type' => 'pdf', 'total'   => 6],
        ['type' => 'xlsx', 'total'   => 6],
        ['type' => 'docx', 'total'   => 6]
    ];

    $link = '';
    if($faker->numberBetween(1,100) < 80)
    {
        $link = $faker->numberBetween(1,$arrayFile[0]['total']) . '.jpg' ;
    }
    else{
        $randType = $faker->numberBetween(1,5);
        $link = $faker->numberBetween(1,$arrayFile[$randType]['total']) . '.' . $arrayFile[$randType]['type'] ;
    }

    return [
        'user_id' =>  $randomUser->id,
        'name'  => $faker->realText(10),
        'link' => $link ,
        'description' => $faker->realText(20),
        'tags' => $faker->realText(10),
        'type' =>  $faker->randomElement(['doc', 'docx','xls', 'ai', 'pdf', 'psd']),
        'material' => $faker->randomElement(['guide', 'office','other']),
        'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')
    ];
});
