<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product_Received;
use Faker\Generator as Faker;

$factory->define(Product_Received::class, function (Faker $faker) {
    return [
        'quantity' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'product_id' => 1,
    ];
});
