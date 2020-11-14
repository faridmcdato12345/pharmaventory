@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex mb-2">
                <div class="mr-2"><button class="btn btn-primary" id="back">BACK</button></div>
                <div class="mr-2"><button class="btn btn-danger">PRINT</button></div>
                <div class="mr-2"><button class="btn btn-success">EXCEL</button></div>
                <div class="mr-2"><button class="btn btn-warning">PDF</button></div>
            </div>
            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>BARCODE</th>
                        <th>PRODUCT NAME</th>
                        <th>DESCRIPTION</th>
                        <th>PURCHASED PRICE</th>
                        <th>RESELL PRICE</th>
                        <th>REMAINING QUANTITY</th>
                        <th>ORDERED QUANTITY</th>
                        <th>SALES VALUE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->products->barcode}}</td>
                        <td>{{$invoice->products->name}}</td>
                        <td>{{$invoice->products->description}}</td>
                        <td>
                            @php
                            $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                            $value = $invoice->products->PurchasedPriceAsCurrency;
                            $formatted = $amount->format($value); 
                            @endphp
                            {{$formatted}}
                        </td>
                        <td>
                            @php
                            $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                            $value = $invoice->products->PriceAsCurrency;
                            $formatted = $amount->format($value); 
                            @endphp
                            {{$formatted}}
                        </td>
                        <td>{{$invoice->products->quantity}}</td>
                        <td>{{$invoice->quantity}}</td>
                        <td>
                            @php
                            $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                            $value = $invoice->products->PriceAsCurrency * $invoice->quantity;
                            $formatted = $amount->format($value);
                            @endphp
                            {{$formatted}}
                        </td>
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
        var table = $('#myTable').DataTable({
            stateSave: true,
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection