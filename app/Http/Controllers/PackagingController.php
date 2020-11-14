<?php

namespace App\Http\Controllers;

use App\Packaging;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packagings = Packaging::all();
        return view('admin.packaging.index',compact('packagings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packaging.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $packaging = Packaging::create(request()->all());
        return $this->productsAttribute('packagings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function show(Packaging $packaging)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function edit(Packaging $packaging)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Packaging $packaging)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packaging $packaging)
    {
        //
    }
}
