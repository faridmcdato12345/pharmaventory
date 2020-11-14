@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    @include('includes.alerts')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <form method="post" action="{{route('storage.store')}}">
                    {{csrf_field()}}
                        <div class="row pt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="storage" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button class="btn btn-danger" onclick="window.location.href='{{route('storage.index')}}'">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection