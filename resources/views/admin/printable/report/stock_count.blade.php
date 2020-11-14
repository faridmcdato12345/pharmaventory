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
            @page{
                size: landscape;
            }
            table {
                font-size: 12px;
            }
            * {
                padding:1px;
            }
        }
        table td, table thead th, table tr th {
            border: 2px solid black !important;
        }
    </style>
</head>
<body onload="window.print()" onafterprint="window.close()">
    <div class="container">
        <div class="m-4 text-center">
            <h1 class="font-extrabold text-3xl">STOCK COUNT AND VALUE REPORT</h1>
            <p class="mt-2 mb-2">by</p>
            <p class="text-md italic">{{$business[0]->name}}</p>
        </div>
        <div class="m-4">
            <p>Prepared date: {{$date}}</p>
        </div>
        <table id="myTable" class="display nowrap table table-responsive" style="border:2px solid black;" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>BARCODE</th>
                    <th>PRODUCT NAME</th>
                    <th>DESCRIPTION</th>
                    <th>PURCHASED PRICE</th>
                    <th>RESELL PRICE</th>
                    <th>QUANTITY</th>
                    <th>STOCK VALUE</th>
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
                        $value=$value/100;
                        $formatted = $amount->format($value); 
                        @endphp
                        {{$formatted}}
                    </td>
                    <td>
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $value = $product->retail_price;
                        $value=$value/100;
                        $formatted = $amount->format($value); 
                        @endphp
                        {{$formatted}}
                    </td>
                    <td>{{$product->quantity}}</td>
                    <td id="stock_value">
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $value = $product->quantity * $product->retail_price;
                        $value=$value/100;
                        $formatted = $amount->format($value); 
                        @endphp
                        {{$formatted}}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td class="description" colspan="3">TOTAL INVESTMENT:</td>
                    <td class="price" colspan="4" align="right">
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $formatted = $amount->format($totalInvestment);
                        @endphp
                        {{$formatted}}
                    </td>
                </tr>
                <tr>
                    <td class="description" colspan="3">TOTAL REVENUE:</td>
                    <td class="price" colspan="4" align="right">
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $formatted = $amount->format($totalRevenue);
                        @endphp
                        {{$formatted}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>