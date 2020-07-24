<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        "hotel" => $faker->name,
        "hotelFare" => $faker->number,
        "hotelRate" => $faker->numberBetween(0, 5),
    ];
});
