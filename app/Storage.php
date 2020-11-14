<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $guarded = [];

    public function products(){
        return $this->belongsToMany(Product::class,'product_storage','storage_id','product_id');
    }
}
