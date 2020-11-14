@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-2">
            <a href="{{route('user.create')}}" class="btn btn-primary">Add User</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <input type="hidden" value="{{$user->id}}" id="user_id">
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->roles->name}}</td>
                                    <td>
                                        @if ($user->status == 1)
                                            ACTIVE
                                        @else
                                            INACTIVE
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($user->status == 1)
                                            <a href="javascript:void(0)" class="edit btn btn-danger btn-sm userInActive">In Active</a>
                                        @else
                                            <a href="javascript:void(0)" class="edit btn btn-primary btn-sm userActive">Active</a>
                                           
                                        @endif
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
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        stateSave: true,
    });
    $('body').on('click','.userActive',function () {
        var u = $(this).closest('tr').find('#user_id').val();
        var urlUpdate = "{{route('user.active',':id')}}";
        urlUpdate = urlUpdate.replace(':id',u);
        $(this).html('Updating..');
        $.ajax({
            url: urlUpdate,
            type: "PATCH",
            dataType: 'json',
            success: function (data) {
                window.location.reload()
            },
            error: function (data) {
                console.log('Error:', data);
                $('#updateBtn').html('User Updated');
            }
        });
    });
    $('body').on('click','.userInActive',function () {
        var u = $(this).closest('tr').find('#user_id').val();
        var urlUpdate = "{{route('user.inactive',':id')}}";
        urlUpdate = urlUpdate.replace(':id',u);
        $(this).html('Updating..');

            $.ajax({
            url: urlUpdate,
            type: "PATCH",
            dataType: 'json',
            success: function (data) {
                window.location.reload()
            },
            error: function (data) {
                console.log('Error:', data);
                $('#updateBtn').html('User Updated');
            }
        });
    });
});
</script>
@endsection