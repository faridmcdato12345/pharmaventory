<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Potency;
use Faker\Generator as Faker;

$factory->define(Potency::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
    ];
});
