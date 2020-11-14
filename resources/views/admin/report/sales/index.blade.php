@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <div class="card">
                <div class="card-body">
                    @if (Session::has('errors'))
                        <div class="alert alert-danger" align="center"><p>{{$errors}}</p></div>
                    @endif
                    <form action="{{route('show.printable.sales')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="from_date">From Date:</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="to_date">To Date:</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Show</button>
                        </div>
                    </form>
                </div>
           </div>
        </div>
    </div>
</div>
@endsection