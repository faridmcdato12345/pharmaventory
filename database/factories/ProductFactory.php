<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'unit_id' => 1,
        'user_id' => 1,
        'barcode' => $faker->ean13,
        'description'=>$faker->word,
        'price'=>100,
        'quantity'=>1000,
        'expiration' => '05/14/1990',
        'size'=>'small',
    ];
});
