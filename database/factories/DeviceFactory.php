<?php

use Faker\Generator as Faker;

$factory->define(App\Device::class, function (Faker $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'name' => $faker->numerify('Device ##'),
        'ip_address' => $faker->ipv4,
        'mac_address' => $faker->macAddress,
        'group_id' => function () {
            return factory(App\Group::class)->create()->id;
        },
        'connected_at' => $faker->dateTime(),
    ];
});
