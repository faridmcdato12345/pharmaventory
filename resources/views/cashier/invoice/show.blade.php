<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div class="container" id="app">
        <div class="container-fluid pt-2">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="mb-4">
                    <a href="{{route('invoice.all')}}" class="btn btn-danger">Back</a>
                    </div>
                    <div class="card">
                       <div class="card-body">
                           <div class="mb-4">
                                <p>Invoice Number : <span class="font-extrabold">{{$invoices[0]->invoice_number}}</span></p>
                                <p>Transaction Date : <span class="font-extrabold">{{$invoices[0]->created_at}}</span></p>
                                <p>Sell Amount : <span class="font-extrabold">@php
                                    $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                    $formatted = $amount->format($total);
                                    @endphp
                                    {{$formatted}}</span>
                                </p>
                                <p>Invested Amount : <span class="font-extrabold">
                                    @php
                                    $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                    $formatted = $amount->format($capital);
                                    @endphp
                                    {{$formatted}}</span>
                                </p>
                                <p>Revenue : <span class="font-extrabold">
                                    @php
                                    $revenue = $total - $capital;
                                    $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                    $formatted = $amount->format($revenue);
                                    @endphp
                                    {{$formatted}}</span>
                                </p>
                           </div>
                            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="quantity">Quantity</th>
                                        <th class="description">Barcode</th>
                                        <th class="description">Description</th>
                                        <th class="price">Price</th>
                                        <th class="price">Sub Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                    <tr>
                                        <input type="hidden" value="{{$invoice->id}}" id="invoice_id">
                                        <input type="hidden" value="{{$invoice->products->id}}" id="product_id">
                                        <td class="quantity">{{$invoice->quantity}}</td>
                                        <td class="description">{{$invoice->products->barcode}}</td>
                                        <td class="description">{{$invoice->products->description}}</td>
                                        <td class="price">{{$invoice->products->retail_price / 100}}</td>
                                        <td class="price">
                                            @php
                                            $subtotal = $invoice->products->retail_price * $invoice->quantity;
                                            $subtotal = $subtotal / 100;
                                            $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                            $formatted = $amount->format($subtotal);
                                            @endphp
                                            {{$formatted}}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" id="return">Return</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="description" colspan="2">GRAND TOTAL:</td>
                                        <td class="price" colspan="4" align="right">
                                            @php
                                            $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                            $formatted = $amount->format($total);
                                            @endphp
                                            {{$formatted}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{asset('js/app.js')}}"></script>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('click','#return',function(){
        let product_id = $(this).closest('tr').find('#product_id').val();
        let invoice_id = $(this).closest('tr').find('#invoice_id').val();
        let quantity = $(this).closest('tr').find('td:first').text();
        console.log(quantity)
        $.ajax({
            data:{
                product_id:product_id,
                invoice_id:invoice_id,
                quantity:quantity
            },
            url: "{{route('return.product')}}",
            method:"post",
            type: "json",
            success:function(data){
                window.location.reload();
            }
        })
    })
});
</script>
</html>