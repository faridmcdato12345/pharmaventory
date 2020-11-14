@extends('layouts.admin')
@section('content')
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
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
                            </tr>
                            @endforeach
                            <tr>
                                <td class="description" colspan="2">GRAND TOTAL:</td>
                                <td class="price" colspan="3" align="right">
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
@endsection