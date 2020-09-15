<?php

namespace App\Http\Controllers;

use App\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function store(){
        ProductType::create(request()->all());
    }
    public function update(ProductType $productType){
        $productType->update(request()->all());
    }
    public function destroy(ProductType $productType){
        $productType->delete();
    }
}
