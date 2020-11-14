<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
