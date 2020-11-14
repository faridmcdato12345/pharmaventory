<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUserController extends Controller
{
    public function index(){
        $users = User::all();
        if(session('success_message')){
            Alert::success('Success!',session('success_message'));
        }
        return view('admin.user.index',compact('users'));
    }
    public function create(){
        $roles = Role::all();
        return view('admin.user.create',compact('roles'));
    }
    public function store(Request $request){
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        return redirect()->route('user.index')->withSuccessMessage('Successfully added!');
    }
    public function changePass(Request $request)
    {
        $request->validate([
            'old' => ['required', new MatchOldPassword],
            'password' => ['required'],
            'new_password' => ['same:new_password'],
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        Auth::logout();
        return redirect('/login');
    }
    public function isActive($id){
        $user = User::find($id);
        $user->status = '1';
        $user->save();
        return response()->json(['success'=>'status updated.']);
    }
    public function inActive($id){
        $user = User::find($id);
        $user->status = '0';
        $user->save();
        return response()->json(['success'=>'status updated.']);
    }
}
