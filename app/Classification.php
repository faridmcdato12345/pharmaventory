<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = ['name'];

    public function products(){
        return $this->hasOne(Product::class,'class_id');
    }
}
