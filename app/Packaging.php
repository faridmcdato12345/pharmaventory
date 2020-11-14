<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    protected $fillable = ['name'];

    public function products(){
        return $this->belongsToMany(Product::class,'packaging_product','packaging_id','product_id');
    }
}
