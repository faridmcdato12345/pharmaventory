<?php

namespace App\Http\Controllers;

use App\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function store(){
        Classification::create(request()->all());
    }
    public function update(Classification $classification){
        $classification->update(request()->all());
    }
    public function destroy(Classification $classification){
        $classification->delete();
    }
}
