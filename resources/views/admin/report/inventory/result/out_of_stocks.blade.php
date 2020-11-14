@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex mb-4">
    <div class="mr-2"><button class="btn btn-primary" onclick="window.open('{{route('print.out_of_stock')}}','_blank')">PRINT</button></div>
        <div class="mr-2"><button class="btn btn-danger" onclick="window.location.href='{{route('inventory.report')}}'">BACK</button></div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card mt-4">
                <div class="card-body">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>CATEGORY</th>
                                <th>BRAND</th>
                                <th>PRODUCT NAME</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{$product->categories()->first()['name']}}</td>
                                    <td>{{$product->brands()->first()['name']}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->description}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <h4>No Product that is out of stock</h4>  
                                    </td>
                                </tr>
                            @endforelse 
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
    });

</script>
@endsection