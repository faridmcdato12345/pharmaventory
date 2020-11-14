<?php

namespace App\Http\Controllers;

use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserLogController extends Controller
{
    public function store(){
        UserLog::create(request()->all());
    }
    public function index(){
        $logs = UserLog::all();
        return view('admin.log.index',compact('logs'));
    }
}
