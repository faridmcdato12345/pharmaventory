<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Received extends Model
{
    protected $guarded = [];

    public function products(){
        return $this->belongsTo(Product::class,'id');
    }
}
