<?php

namespace Tests;

use App\Unit;
use App\Brand;
use App\Potency;
use App\Storage;
use App\Category;
use App\ProductType;
use App\Classification;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function foriegnKeys(){
        $class = factory(Classification::class)->create();
        $type = factory(ProductType::class)->create();
        $unit = factory(Unit::class)->create();
        $storage = factory(Storage::class)->create();
        $potency = factory(Potency::class)->create();
        $brand = factory(Brand::class)->create();
        $category = factory(Category::class)->create();
    }
}
