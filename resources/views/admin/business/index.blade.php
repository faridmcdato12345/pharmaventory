@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-2">
            <a href="{{route('business.create')}}" class="btn btn-primary" >Add</a>
            </div>
           <div>
            <div class="card">
                <div class="card-body">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($businesses as $business)
                                <tr>
                                    <td>{{$business->name}}</td>
                                    <td>{{$business->address}}</td>
                                    <td>{{$business->contact_number}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
           </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        stateSave: true,
    });
});
</script>
@endsection