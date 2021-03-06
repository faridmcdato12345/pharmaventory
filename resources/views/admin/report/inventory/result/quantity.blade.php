@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    <div class="d-flex mb-4">
    <div class="mr-2"><button class="btn btn-primary" onclick="window.open('{{route('low.quantity.print',['quantity'=>$quantity])}}','_blank')">PRINT</button></div>
        <div class="mr-2"><button class="btn btn-danger" onclick="window.location.href='{{route('inventory.report')}}'">BACK</button></div>
    </div>
    <div class="card">
        <div class="card-body">
            
            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>BARCODE</th>
                        <th>PRODUCT NAME</th>
                        <th>DESCRIPTION</th>
                        <th>PURCHASED PRICE</th>
                        <th>RESELL PRICE</th>
                        <th>QUANTITY</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{$product->barcode}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td>
                                @php
                                $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                $value = $product->purchase_price;
                                $value = $value/100;
                                $formatted = $amount->format($value); 
                                @endphp
                                {{$formatted}}
                            </td>
                            <td>
                                @php
                                $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                $value = $product->retail_price;
                                $value = $value/100;
                                $formatted = $amount->format($value); 
                                @endphp
                                {{$formatted}}
                            </td>
                            <td>{{$product->quantity}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
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
        });
    });
</script>
@endsection