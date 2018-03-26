<?php

$factory->define(App\Property::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "address" => $faker->name,
    ];
});
