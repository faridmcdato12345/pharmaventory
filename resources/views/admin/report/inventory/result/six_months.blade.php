@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex mb-4">
        
        <div class="mr-2"><button class="btn btn-primary" onclick="window.open('{{route('next.six.months.print')}}','_blank')">PRINT</button></div>
        <div class="mr-2"><button class="btn btn-danger" onclick="window.location.href='{{route('inventory.report')}}'">BACK</button></div>
    </div>
    <div class="card">
        <div class="card-body">
           
            <div class="card mt-4">
                <div class="card-body">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>BARCODE</th>
                                <th>PRODUCT NAME</th>
                                <th>DESCRIPTION</th>
                                <th>EXPIRATION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{$product->barcode}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->description}}</td>
                                <td>{{$product->expiration}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4"><h4>No Product will expire next six months</h4></td>
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
<script type="text/javascript">
$(document).ready(function(){
    $('#back').on('click',function(e){
        window.history.back();
    })
})
</script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            stateSave: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection