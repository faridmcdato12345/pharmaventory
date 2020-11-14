<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'quantity' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'product_id' => 1,
        'invoice_number' => $faker->randomNumber($nbDigits = NULL, $strict = false),
    ];
});
