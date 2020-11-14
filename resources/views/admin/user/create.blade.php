@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    @include('includes.alerts')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <form method="post" action="{{route('user.store')}}">
                    {{csrf_field()}}
                    <div class="row pt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select name="role_id" id="role_id" class="form-control">
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Add</button>
                <button type="button" class="btn btn-danger" onclick="window.location.href='{{route('user.index')}}'">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
