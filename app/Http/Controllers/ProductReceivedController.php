<?php

namespace App\Http\Controllers;

use App\Product_Received;
use Illuminate\Http\Request;

class ProductReceivedController extends Controller
{
    public function store(){
        Product_Received::create(request()->all());
    }
    public function show(Product_Received $product){
        return $product;
    }
}
