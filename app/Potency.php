<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Potency extends Model
{
    protected $guarded = [];

    public function products(){
        return $this->belongsToMany(Product::class,'potency_product','potency_id','product_id');
    }
}
