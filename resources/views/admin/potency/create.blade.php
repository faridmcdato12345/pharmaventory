@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    @include('includes.alerts')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <form id="product-form" name="product-form">
                    <div class="row pt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barcode">Barcode:</label>
                                <input type="text" name="barcode" id="barcode" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="purchased_price">Purchased Price:</label>
                                <input type="text" name="purchase_price" id="purchased_price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="resell_price">Resell Price:</label>
                                <input type="text" name="retail_price" id="resell_price" class="form-control">
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