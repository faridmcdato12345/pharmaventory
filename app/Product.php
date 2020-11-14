<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $dates = ['expiration','purchaseddate'];
    
    
    public function setRetailPriceAttribute($value){
        $this->attributes['retail_price'] = $value*100;
    }
    public function setPurchasePriceAttribute($value){
        $this->attributes['purchase_price'] = $value*100;
    }
    public function getPriceAsCurrencyAttribute(){
        if(isset($this->attributes['retail_price']))
        {
            $amount = new \NumberFormatter("%.2n",\NumberFormatter::CURRENCY);
            $formatted = $amount->format($this->attributes['retail_price']/100);
            return preg_replace( '/[^0-9,"."]/', '', $formatted );
        }
        return False;        
    }
    public function getPurchasedPriceAsCurrencyAttribute(){
        if(isset($this->attributes['purchase_price']))
        {
            $amount = new \NumberFormatter("%.2n",\NumberFormatter::CURRENCY);
            $formatted =  $amount->format($this->attributes['purchase_price']/100);
            return preg_replace( '/[^0-9,"."]/', '', $formatted );
        }
        return False;        
    }
    public function setExpirationAttribute($expiration){
        $this->attributes['expiration'] = Carbon::parse($expiration);
    }
    public function setPurchasedateAttribute($purchasedate){
        $this->attributes['purchasedate'] = Carbon::parse($purchasedate);
    }
    public function classifications(){
        return $this->belongsTo(Classification::class,'class_id');
    }
    public function types(){
        return $this->belongsToMany(Type::class);
    }
    public function units(){
        return $this->belongsTo(Unit::class,'unit_id');
    }
    public function storages(){
        return $this->belongsToMany(Storage::class);
    }
    public function potencies(){
        return $this->belongsToMany(Potency::class);
    }
    public function brands(){
        return $this->belongsToMany(Brand::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
    public function receiveds(){
        return $this->hasMany(Product_Received::class);
    }
    public function packagings(){
        return $this->belongsToMany(Packaging::class);
    }
}
