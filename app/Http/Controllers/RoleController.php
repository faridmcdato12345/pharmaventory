<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(){
        Role::create(request()->all());
    }
    public function update(Role $role){
        $role->update(request()->all());
    }
    public function destroy(Role $role){
        $role->delete();
    }
}
