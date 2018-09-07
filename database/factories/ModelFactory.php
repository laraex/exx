<?php

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Giftcard::class, function (Faker\Generator $faker) {

	$title = $faker->sentence($nbWords = 3, $variableNbWords = true);
	$price = $faker->numberBetween($min = 50, $max = 800);

    return [
        'name'           => $title,
        'slug'			 => str_slug( $title, '-'),
        'image'          => "uploads/giftcards/".$faker->image($dir ="public/uploads/giftcards", $width="360", $height="200", 'abstract', false, true, 'DummyImage'),
        'description'	 => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'valueprice'	 => $price ,
        'buyprice'		 => $price * 1.5,
        'sellprice'		 => $price * 0.9,
        'order'			=> $faker->numberBetween($min = 1, $max = 99),
    ];
});