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
        'name' => 'selinhep',
        'email' => 'celine.eppe@gmail.com',
        'password' => 'password',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Task::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->text(50),
        'completed' => $faker->boolean,
        'user_id' => 1,
        'due_date' => $faker->dateTimeBetween('-5 days', '+1 month'),
        'project_id' => 1,
    ];
});

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
        'color' => $faker->hexcolor(),
        'user_id' => 1,
    ];
});
