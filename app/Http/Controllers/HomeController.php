<?php

namespace App\Http\Controllers;

use App\Business;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role_id == 1){
            $businesses = Business::all();
            return view('admin.index',compact('businesses'));
        }
        elseif(Auth::user()->role_id == 2){
            $products = Product::with(
                'categories',
                'brands',
                'types',
                'potencies',
                'packagings',
                'storages'
            )
            ->where('quantity','>',0)
            ->get();
            return view('cashier.new',compact('products'));
        }
        else{
            return view('pe.index');
        }
    }
    public function adminPos(){
        $products = Product::with(
            'categories',
            'brands',
            'types',
            'potencies',
            'packagings',
            'storages'
        )
        ->where('quantity','>',0)
        ->get();
        return view('cashier.new',compact('products'));
    }
    public function adminNewPos(){
        $products = Product::with(
            'categories',
            'brands',
            'types',
            'potencies',
            'packagings',
            'storages'
        )
        ->where('quantity','>',0)
        ->get();
        return view('cashier.new',compact('products'));
    }
}
