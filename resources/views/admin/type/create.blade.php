@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    @include('includes.alerts')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <form id="product-form" name="product-form">
                    <div class="row pt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
                <input type="submit" name="addProduct" value="Add Product" class="btn btn-primary w-24 addProduct">
                <button class="btn btn-danger" id="cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
