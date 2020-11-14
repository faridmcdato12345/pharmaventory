<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'barcode' => $faker->ean13,
        'description'=>$faker->word,
        'name'=>$faker->name,
        'retail_price'=>'100',
        'purchase_price'=>'100',
        'quantity'=>'1000',
        'expiration' => '05/14/1990',
        'purchasedate' => Carbon::now(),
    ];
});
