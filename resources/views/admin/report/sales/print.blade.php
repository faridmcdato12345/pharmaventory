<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PHARMAVENTORY</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @media print{
            .print_button{
                visibility: hidden;
            }
            @page{
                size: landscape;
            }
            
        }
        table td, table thead th, table tr th {
            border: 2px solid black !important;
        }
        .date-p{
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center" class="p-4">
            <h1><strong>SALES REPORT</strong></h1>
            <p class="date-p">From {{$from_date}} To {{$to_date}}</p>
        </div>
        <div class="mb-2">
            <p>
                @php
                    $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                    $formatted = $amount->format($totalSales);
                @endphp
                Total Sales: <strong>{{$formatted}}</strong>
            </p>
        </div>
        <div class="mb-2">
        <p>
            @php
                $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                $formatted = $amount->format($totalPurchaseCost);
            @endphp
            Total Purchase Cost: <strong>{{$formatted}}</strong>
        </p>
        </div>
        <div class="mb-2">
        <p>
            @php
                $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                $formatted = $amount->format($totalSales - $totalPurchaseCost);
            @endphp
            Total Revenue: <strong>{{$formatted}}</strong>
        </p>
        </div>
        <table id="myTable" class="display nowrap table table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>CATEGORY</th>
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
                    <td>{{$invoice->products->categories()->first()['name']}}</td>
                <td>{{$invoice->products->barcode}}</td>
                    <td>{{$invoice->products->name}}</td>
                    <td>{{$invoice->products->description}}</td>
                    <td>
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $value = $invoice->products->purchase_price;
                        $value = $value/100;
                        $formatted = $amount->format($value); 
                        @endphp
                        {{$formatted}}
                    </td>
                    <td>
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $value = $invoice->products->retail_price;
                        $value = $value/100;
                        $formatted = $amount->format($value); 
                        @endphp
                        {{$formatted}}
                    </td>
                    <td>{{$invoice->products->quantity}}</td>
                    <td>{{$invoice->quantity}}</td>
                    <td>
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $value = $invoice->products->retail_price * $invoice->quantity;
                        $value = $value/100;
                        $formatted = $amount->format($value);
                        @endphp
                        {{$formatted}}
                    </td>
                </tr>
                @endforeach
                
                <tr>
                    <td colspan="4" align="center"><strong>TOTAL</strong></td>
                    <td colspan="5" align="center">
                    @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $formatted = $amount->format($totalSales);
                        @endphp
                    <strong>
                        {{$formatted}}
                    </strong>
                </td>
                </tr>
            </tbody>
        </table>
        <button type="button" onclick="window.print()" class="btn btn-primary print_button">Print</button>
        <a href="{{route('sales.report')}}" class="btn btn-danger print_button">Back</a>
    </div>
</body>
<script src="{{asset('js/app.js')}}"></script>
</html>