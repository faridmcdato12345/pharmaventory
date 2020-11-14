@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    @include('includes.alerts')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
            <form method="post" action="{{route('business.store')}}">
                {{csrf_field()}}
                    <div class="row pt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="barcode">Business Name:</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Address:</label>
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Contact Number:</label>
                                <input type="text" name="contact_number" id="contact_number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" id="cancel" onclick="window.location.href='{{route('business.index')}}'">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection