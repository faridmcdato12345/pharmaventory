<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends Controller
{
    public function index(){
        $types = Type::all();
        return view('admin.type.index',compact('types'));
    }
    public function create(){
        return view('admin.type.create');
    }
    public function store(){
        $type = Type::create(request()->all());
        return $this->productsAttribute('types');
    }
    public function update(Type $type){
        $type->update(request()->all());
    }
    public function destroy(Type $type){
        $type->delete();
    }
}
