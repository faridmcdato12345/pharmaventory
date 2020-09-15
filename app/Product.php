<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $dates = ['expiration'];

    public function setExpirationAttribute($expiration){
        $this->attributes['expiration'] = Carbon::parse($expiration);
    }
}
