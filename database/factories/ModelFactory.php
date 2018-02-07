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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->jobTitle,
        'content' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'image' => $faker->image($dir = 'public/front-end/dashboard/dist/img', $width = 640, $height = 480),
        'author' => $faker->firstName,
        'created_post' =>\Carbon\Carbon::today(),
        'status_post' => 0
    ];
});

$factory->define(App\Models\Category::class,function(Faker\Generator $faker) {
    return [
        'category' => $faker->jobTitle,
        'description' => $faker->sentences($nbWords = 6, $variableNbWords = true)
    ];
});