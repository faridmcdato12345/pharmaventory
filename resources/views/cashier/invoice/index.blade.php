<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div class="container" id="app">
        <div class="container-fluid pt-2">
            <div class="row justify-content-center">
                <div class="col-md-12">
                <button class="btn btn-danger mb-4" onclick="window.location.href='{{route('home')}}'">Back</button>
                   <div class="card">
                       <div class="card-body">
                            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{$invoice->invoice_number}}</td>
                                            <td class="text-nowrap">
                                            <a class="btn btn-info btn-sm" href="{{route('invoice.show',['id'=>$invoice->invoice_number])}}" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-eye text-white "></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
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
    $(document).ready(function() {
        $('#myTable').DataTable({
            stateSave: true,
            lengthMenu: [[5,10,20,50,-1],[5,10,20,50,"All"]],
        });
        $('#myTable_wrapper input[type="search"]').focus()
    });
</script>
</html>