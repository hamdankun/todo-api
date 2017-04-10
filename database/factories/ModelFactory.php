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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->username,
        'email' => $faker->email,
        'password' => app('hash')->make('password')
    ];
});

$factory->define(App\Todo::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'title' => $faker->realText(100),
        'date' => $faker->date,
        'notify' => $faker->boolean,
        'description' => $faker->sentence
    ];
});
