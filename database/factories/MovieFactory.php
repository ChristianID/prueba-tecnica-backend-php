<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {

    $id = rand(0, 1000);

    return [
        'title' => $faker->sentence(4, true),
        'thumbnail' => "https://picsum.photos/id/$id/700/700.jpg",
        'release_date' => $faker->dateTimeBetween('-5 years', 'now', null),
        'on_billboard' => rand(0, 1)
    ];
});
