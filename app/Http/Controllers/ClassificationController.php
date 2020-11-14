<?php

namespace App\Http\Controllers;

use App\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function store(){
        Classification::create($this->dataValidate());
    }
    public function update(Classification $classification){
        $classification->update($this->dataValidate());
    }
    public function destroy(Classification $classification){
        $classification->delete();
    }
    public function show(Classification $classification){
        return $classification;
    }
}
