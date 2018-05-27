<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'middle_name' => $faker->name,
        'user_type' => 1,
        'last_name' => $faker->name,
        'email' => 'edward@io.com',
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
// Special Orders, Memorandums, Letters, Telephone Directory, Finance, BAC, HR, Other Forms
$factory->define(App\Category::class, function (Faker $faker) {
    return [

            ['title' => 'Special Orders'],
            ['title' => 'Memorandums'],
            ['title' => 'Letters'],
            ['title' => 'Telephone'],
            ['title' => 'Directory'],
            ['title' => 'Finance'],
            ['title' => 'BAC'],
            ['title' => 'HR'],
            ['title' => 'Other Forms']
        ];
});
