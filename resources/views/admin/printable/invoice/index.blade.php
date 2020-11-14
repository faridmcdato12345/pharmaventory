<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <style>
        @font-face {
            font-family: 'VCR_OSD_MONO_1.001';
            src: url('{{ base_path("public\\fonts\\VCR_OSD_MONO_1.001.ttf") }}');
        }
        @media print{
            
            * {
                font-family: 'VCR_OSD_MONO_1.001';
                font-weight: bold;
                font-size:18px;
            }
            @page{
                margin: 0px!important;
                padding: 0px!important;
            }
            *{
                margin: 1px!important;
                padding: 0px!important;
            }
        }
        * {
            font-size: 12px;
            font-family:'VCR_OSD_MONO_1.001';
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
            word-break: break-all;
        }

        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 65mm;
            max-width: 65mm;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        @media print {
            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
</head>
<body onload="window.print()" onafterprint="window.close()">
    <div class="ticket">
        <p class="centered">{{$business[0]->name}}
            <br>Address: {{$business[0]->address}}
            <br>Contact #: {{$business[0]->contact_number}}</p>
        <table style="width:100%;padding:0px;">
            <thead>
                <tr>
                    <th class="quantity">Qty.</th>
                    <th class="description">Dctpn</th>
                    <th class="price">Price</th>
                    <th class="price">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td class="quantity">{{$invoice->quantity}}</td>
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
        <svg id="barcode"></svg>
        <p class="centered">Thanks for your purchase!</p>
    </div>
</body>
<script src="{{asset('js/jsbarcode.min.js')}}"></script>
<script>
    let invoiceBarcode = "{{$invoice->invoice_number}}"
    JsBarcode("#barcode",invoiceBarcode);
</script>
</html>