<?php

$factory->define(App\Document::class, function (Faker\Generator $faker) {
    return [
        "property_id" => factory('App\Property')->create(),
        "user_id" => factory('App\User')->create(),
        "name" => $faker->name,
    ];
});
