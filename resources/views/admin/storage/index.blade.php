@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-4">
                <a href="#" class="btn btn-primary" onclick="window.location.href='{{route('storage.create')}}'">Add Storage</a>
            </div>
           <div>
            <div class="card">
                <div class="card-body">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storages as $storage)
                                <tr>
                                    <td>{{$storage->name}}</td>
                                    <td class="text-nowrap">
                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete{{ $storage->id }}"  data-original-title="Close"> <i class="fas fa-trash-alt text-white "></i></a>
                                        <div class="modal fade" id="confirm-delete{{ $storage->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('storage.delete' , $storage->id )}}" method="post">
                                                        {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            Are you sure you want to delete this Storage?
                                                        </div>
                                                        <div class="modal-header">
                                                            <h4>{{ $storage->name }}</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <button  type="submit" class="btn btn-danger btn-ok">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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