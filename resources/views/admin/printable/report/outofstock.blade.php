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
            <h1 class="font-extrabold text-3xl">OUT OF STOCK PRODUCTS</h1>
            <p class="mt-2 mb-2">by</p>
            <p class="text-md italic">{{$business[0]->name}}</p>
        </div>
        <div class="m-4">
            <p>Prepared date: {{$date}}</p>
        </div>
        <table id="myTable" class="display nowrap table table-responsive" style="border:2px solid black;" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>CATEGORY</th>
                    <th>BRAND</th>
                    <th>PRODUCT NAME</th>
                    <th>PRODUCT DESCRIPTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{$product->categories()->first()['name']}}</td>
                    <td>{{$product->brands()->first()['name']}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>