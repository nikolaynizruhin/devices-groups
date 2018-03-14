<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'name' => $faker->numerify('Group ##'),
    ];
});
