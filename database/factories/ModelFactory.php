<?php

use App\Models\Puzzle;
use App\Models\PuzzleTemplate;
use App\Models\User;

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

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->username,
        'name' => $faker->name,
        'created_timestamp_utc' => $faker->randomDigitNotNull,
        'updated_timestamp_utc' => $faker->randomDigitNotNull,
    ];
});

$factory->define(Puzzle::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
    ];
});

$factory->define(PuzzleTemplate::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
        'slug' => $faker->md5,
        'created_timestamp_utc' => $faker->randomDigitNotNull,
        'updated_timestamp_utc' => $faker->randomDigitNotNull,
    ];
});
