@extends('layouts.admin')
@section('content')
<div class="card m-2">
    <div class="card-body">
        @if (Session::has('errors'))
            <div class="alert alert-success" align="center"><p>{{$errors}}</p></div>
        @endif
        <br>
        <h4 class="card-title">File Upload</h4>
        <br>
        <form action="{{route('product.import.store')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
               <input type="file" name="document" id="document" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Upload</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='{{route('product.index')}}'">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection