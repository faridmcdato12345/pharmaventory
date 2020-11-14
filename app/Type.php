<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name'];

    public function products(){
        return $this->belongsToMany(Product::class,'product_type','type_id','product_id');
    }
}
