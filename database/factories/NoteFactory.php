<?php

$factory->define(App\Note::class, function (Faker\Generator $faker) {
    return [
        "property_id" => factory('App\Property')->create(),
        "user_id" => factory('App\User')->create(),
        "note_text" => $faker->name,
    ];
});
