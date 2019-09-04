<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cat;
use Faker\Generator as Faker;

$factory->define(Cat::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'photo' => $faker->imageUrl(150, 100, 'cats'),
        'character' => $faker->randomElement(['good', 'bad', 'nice', 'angry'], 2),
        'age' => $faker->randomElement([1,3,2,5,4]),
    ];
});
