<?php

use Faker\Generator as Faker;

$factory->define(App\Models\News::class, function (Faker $faker) {
    return [
        'title'           => $faker->sentence,
        'story'          => $faker->text(10000),
        'language'       => "en",
        'active'         => 1,
    ];
});
