<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function store(){
        Unit::create(request()->all());
    }
    public function update(Unit $unit){
        $unit->update(request()->all());
    }
    public function destroy(Unit $unit){
        $unit->delete();
    }
}
