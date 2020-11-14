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
        .sticky-table th{
            position:sticky;
            top:0;
            background-color: aliceblue;
        }
        .sticky-table td:hover {
            cursor: pointer;
        }
        .greaterThanOneBody tr:hover{
            cursor: pointer;
            background-color: #f9f9f9;
        }
        .table-tbody tr:hover{
            cursor: pointer;
            background-color: #f9f9f9;
        }
        .table-tbody{
            background-color: #ffffff;
        }
        .total_sum{
            font-size: 100px !important;
            text-align: left;
        }
        .paid_button{
            min-height: 75px;
            height:75px;
        }
        .paid_button button{
            font-size: 45px;
            font-weight: bolder;
            letter-spacing: 10px;
        }
        @media screen and (max-width: 1280px) {
            h3 {
                font-size: 60px !important;
            }
            .timers{
                font-size: 50px!important;
            }
            .h-50 {
                height: 38% !important;
            }
        }
        @media screen and (min-width:1280px) and (max-width: 1365px) {
            h3 {
                font-size: 65px !important;
            }
            .timers{
                font-size: 50px!important;
            }
            .h-50 {
                height: 38% !important;
            }
        }
        @media screen and (min-width:1366px) and (max-width: 1599px) {
            h3 {
                font-size: 70px !important;
            }
            .timers{
                font-size: 50px!important;
            }
            .h-50 {
                height: 34% !important;
            }
        }
        @media screen and (min-width:1600px) {
            h3 {
                font-size: 70px !important;
            }
            .timers{
                font-size: 50px!important;
            }
            .h-50 {
                height: 38% !important;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid bg-dark h-screen" id="app">
        <div class="row p-0 h-screen">
            <div class="col-md-9 pr-0 relative block">
                <div class="card m-0 h-screen">
                    <div class="card-body">
                        <div class="row header h-32">
                            <div class="col-md-8">
                                <h3 class="text-dark text-center display-3 mb-1 font-weight-bold">PHARMAVENTORY</h3>
                                <hr>
                                <p class="text-dark h-5 text-center">Point of Sale & Inventory Management System</p>
                            </div>
                            <div class="col-md-4 bg-dark d-flex justify-content-center align-items-center border border-success rounded ">
                                <h1 class="text-success display-4 font-weight-bold timers" id="txt"></h1>
                            </div>
                        </div>
                        <div class=" text-black bg-gray-600 relative p-2 mt-2 overflow-hidden overflow-y-hidden" style="height:80vh;">
                            <div class="pt-2 relative w-full text-gray-600 mb-4">
                                <input id="search" class="form-control border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-xl font-bold focus:outline-none pt-4 pb-4"
                                  type="search" name="search" placeholder="Search" autofocus>
                                <button type="submit" class="absolute right-0 top-0 mt-4 mr-4">
                                  <li class="fas fa-search"></li>
                                </button>
                            </div>
                            <div class="w-full product-table h-75 relative table-responsive-xl">
                                <table class="table sticky-table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">#</th>
                                            <th class="px-4 py-2">BARCODE</th>
                                            <th class="px-4 py-2">PRODUCT NAME</th>
                                            <th class="px-4 py-2">DESCRIPTION</th>
                                            <th class="px-4 py-2">QUANTITY</th>
                                            <th class="px-4 py-2">PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="relative mt-24 table-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 pl-1 position-relative">
                <div class="card h-100 m-0 max-h-screen min-h-screen">
                    <div class="card-body pl-1 pr-1">
                        <div class="flex pb-2">
                            @if(Auth::user()->role_id == 1)
                            <div class="btn btn-primary form-control h-auto" id="return">
                                <i class="fa fa-arrow-left"></i>
                                <p class="mb-0">BACK</p>
                            </div>
                            @else
                            <div class="btn btn-primary form-control h-auto" data-target="#setting_modal" data-toggle="modal" data-original-title="Setting">
                                <i class="fa fa-cog"></i>
                                <p class="mb-0">SETTING</p>
                            </div>
                            @endif
                            <div class="btn btn-primary form-control h-auto mx-2 refresh_button">
                                <i class="fa fa-redo"></i>
                                <p class="mb-0">REFRESH (f5)</p>
                            </div>
                            <div class="btn btn-primary form-control h-auto mx-2" onclick="cancelItems()">
                                <i class="fa fa-times"></i>
                                <p class="mb-0">CANCEL ITEMS</p>
                            </div>
                        </div>
                        <div class="flex pb-2">
                            <div class="btn btn-primary form-control h-auto paid_button">
                                <i class="fa fa-money-bill-alt"></i>
                                <p class="mb-0">PAYMENT</p>
                                <p>(f2)</p>
                            </div>
                            <a class="btn btn-primary form-control h-auto mx-2" data-target="#search_button" data-toggle="modal" data-original-title="Search">
                                <i class="fas fa-search"></i>
                                <p class="mb-0">SEARCH</p>
                            </a>
                            @if (Auth::user()->role_id != 1)
                            <div class="btn btn-primary form-control h-auto mx-2" onclick="window.location.href='{{route('invoice.all')}}'">
                                <i class="fa fa-receipt"></i>
                                <p class="mb-0">INVOICES</p>
                            </div>
                            @endif
                        </div>
                        <div class="flex b-2">
                            <div class="btn btn-danger form-control h-auto">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out-alt"></i>
                                <p class="mb-0">LOGOUT</p>
                                </a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                        <div class="grand_total_div absolute bottom-0">
                            <div class="card total_price text-success bg-dark h-48 md:h-32">
                                <div class="card-body p-1">
                                    <label for="payment" class="text-5xl md:text-3xl">GRAND TOTAL:</label>
                                </div>
                                <input type="text" name="total" id="total" value="0.00" class="form-control font-extrabold text-6xl md:text-5xl" autofocus disabled>
                            </div>
                            <div class="card payment text-success bg-dark h-48 md:h-32">
                                <div class="card-body p-1">
                                    <label for="payment" class="text-5xl md:text-3xl">TENDERED:</label>
                                </div>
                                <input type="text" name="payment" value="0.00" id="payment" class="form-control font-extrabold text-6xl md:text-5xl" autofocus>
                            </div>
                            <div class="card change text-success bg-dark h-48 md:h-32">
                                <div class="card-body p-1">
                                    <label for="change" class="text-5xl md:text-3xl">CHANGE:</label>
                                </div>
                                <input type="text" name="change" value="0.00" id="change" class="form-control font-extrabold text-6xl md:text-5xl" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Header</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label for="quantity">Quantity:</label>
                <input type="text" name="quantity" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Add Item</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
      
        </div>
    </div>
    <div id="addQuantityModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
          <!-- Modal content-->
          <div class="modal-content bg-dark">
            <div class="modal-body">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" class="form-control text-6xl text-center font-extrabold" required autofocus>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary add_item" data-dismiss="modal" id="add_item">Add Item</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
      
        </div>
    </div>
    <!---This modal show if more than 1 product was been search-->
    <div id="greaterThanOne" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width:100%;max-width:100%;">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
                <table class="table-responsive table">
                    <thead>
                        <th>#</th>
                        <th>Categories</th>
                        <th>Brands</th>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Expiration</th>
                        <th>Potencies</th>
                        <th>Types</th>
                        <th>Packagings</th>
                    </thead>
                    <tbody class="greaterThanOneBody">

                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
    
    <!-- end modal show > 1 searched-->
    <!---This modal search button-->
    <div id="search_button" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:100%;max-width:100%;">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
                <table class="display nowrap table table-hover table-striped table-bordered" id="seach_product_table" cellspacing="0" width="100%">
                    <thead>
                        <th>#</th>
                        <th>Storage Location</th>
                        <th>Categories</th>
                        <th>Brands</th>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Expiration</th>
                        <th>Potencies</th>
                        <th>Types</th>
                        <th>Packagings</th>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->storages()->first()['name']}}</td>
                                <td>{{$product->categories()->first()['name']}}</td>
                                <td>{{$product->brands()->first()['name']}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->barcode}}</td>
                                <td>{{$product->description}}</td>
                                <td> 
                                    @php
                                    $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                    $value = $product->PriceAsCurrency;
                                    $formatted = $amount->format($value); 
                                    @endphp
                                    {{$formatted}}
                                </td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->expiration->format('m/d/yy')}}</td>
                                <td>{{$product->potencies()->first()['name']}}</td>
                                <td>{{$product->types()->first()['name']}}</td>
                                <td>{{$product->packagings()->first()['name']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    
    <!-- end modal search button-->
    <!--modal for setting--->
    <div id="setting_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
                <p class="text-3xl font-bold">User Information</p> 
                <hr>
                <p>Username: <span>{{Auth::user()->username}}</span></p>
                <p>Role: <span>{{Auth::user()->roles->name}}</span></p>
                <p class="text-3xl font-bold">Change Password</p> 
                <hr>
                <form action="{{route('change.password')}}" method="post" role="form" class="form-horizontal">
                    {{csrf_field()}}
                        <div class="form-group{{ $errors->has('old') ? ' has-error' : '' }}">
                            <label for="password">Current Password</label>
                            <div>
                                <input id="password" type="text" class="form-control" name="old" id="old">
                                @if ($errors->has('old'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">New Password</label>
                            <div>
                                <input id="password" type="text" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <label for="new_password">Confirm New Password</label>
                            <div>
                                <input id="new_password" type="text" class="form-control" name="new_password">
                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('new-password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                </form>
            </div>
          </div>
      
        </div>
    </div>
    <!---end modal for setting-->
</body>
@include('sweetalert::alert')
<script src="{{asset('js/app.js')}}"></script>
<script>
    $(document).ready(function(){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let table = $('#seach_product_table').DataTable({
            stateSave: true,
            pageLength: 5,
            lengthMenu: [[5,10,20,50,-1],[5,10,20,50,"All"]]
        });
        let product_obj_id = [];
        let total_price = [];
        let sum,payment;
        $('.refresh_button').click(function(){
            location.reload()
        })
        $('#return').click(function(){
            window.history.back()
        })
        startTime()
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            var ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12;
            h = h ? h : 12;
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =
            h + ":" + m + ":" + s + ' ' + ampm;
            var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }
        document.getElementById("search").focus();
        // fetchProduct();
        
        
        $('body').keydown(function(event){
            if(event.which == 113){ //pressing f2
                paidFunction()
            }
            if(event.which === 114){
                $('#payment').val('')
                return false;
                var resetAutoFocus = document.getElementById('search')
                resetAutoFocus.autofocus = false
                let paymentFocus = document.getElementById('payment')
                paymentFocus.focus()
            }
        });
        $('body').on('click','.paid_button',function(){
            paidFunction()
        })
        
        paidFunction = () => {
            if(payment >= sum){
                $.ajax({
                    data: JSON.stringify(product_info),
                    url: "{{route('invoice.store')}}",
                    type: "POST",
                    dataType: "json",
                    success: function(data){
                        console.log("invoice_number: " + JSON.parse(data.data))
                        $('tbody.table-tbody').html('')
                        successToast.fire({
                            type: 'success',
                            title: 'Transaction Successful! Press F5 for NEW TRANSACTION'
                        },function(){
                            window.reload()
                        },1000)
                        let invoiceRoute = "{{route('print.invoice',':i')}}";
                        invoiceRoute = invoiceRoute.replace(':i',JSON.parse(data.data))
                        window.open(invoiceRoute,'_blank')
                    }
                });
            }
            else{
                console.log("payment is < sum") 
            }
        }
        $(document).on('keyup','#payment',function(){
            payment = $(this).val()
            if(payment >= sum){
                let change = payment - sum
                $('#change').val("P " + change.toFixed(2))
            }
            else {
                $('#change').val('0.00')
            }
        })
        showModal = (id,name) => {
            let productName = name.toUpperCase();
            $('.modal-title').html("<strong>" + productName + "</strong>")
            
            $('#myModal').modal({ 
                backdrop: 'static',
                keyboard: false
            },'show')
            document.getElementById("quantity").focus();
        }
        let differenc,index;
        let product_info = []
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var d = today.getDate()
        var mo = today.getMonth()
        var y = today.getFullYear()
        const invoice = d+""+mo+""+y+""+h+""+m+""+s 
        $('.add_item').click(function(){
            let quantity = $('#quantity').val()
            
            if(quantity != ""){
                $.ajax({
                url: "{{route('get.product')}}",
                type: "json",
                method: "GET",
                data: {
                    product_id:id,
                    product_quantity: quantity
                },
                success:function(data){
                    let obj = JSON.parse(data);
                    total_price.push(obj.sum_total)
                    $('tbody.table-tbody').append(obj.item)
                    product_info.push({
                        "product_id":obj.product_id,
                        "quantity":obj.quantity,
                        "invoice_number":invoice
                    })
                    sum = total_price.reduce(function(a,b){
                        return a + b;
                    },0)
                    const formatter = new Intl.NumberFormat('en-PH',{
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    })
                    $('.total_price input[type="text"]').val(formatter.format(sum))
                    $("#addQuantityModal").modal('hide') 
                    $('#quantity').val('')
                    $('#search').val('')
                    document.getElementById("search").focus();
                    console.log("product_info added: " + JSON.stringify(product_info))
                    console.log("total sum added: " + JSON.stringify(total_price))
                }
                })
                    
            }
            else{
                alert('Quantity field must have value!')
            }
            
            
        })
        difference = sum
        $('body').on('click','.delete_item_from_invoice',function(){
            let row_index = $(this).closest("tr").index()
                console.log("row index:"+row_index)
                console.log("total_price[row_index]: " + total_price[row_index])
                index = total_price.indexOf(total_price[row_index])
                console.log("index: "+index)
                if (index >= 0) {
                    total_price.splice(index, 1);
                    $(this).closest("tr").remove()
                }
                console.log("remain object after delete: " + total_price)
                difference = total_price.reduce(function(a,b){
                    return a + b;
                },0)
                $('.total_price .card-body').html("<h1 class='total_sum'>P "+difference.toFixed(2)+"</h1>")
        })
        const Toast = Swal.mixin({
            icon: "error",
            position: 'center',
            showConfirmButton: false,
            timer: 1000
        });
        const successToast = Swal.mixin({
            icon: "success",
            position: 'center',
            showConfirmButton: true,
            timer: 1000000
        });
        $(document).on('keypress',function(e){
            if(e.which == 13){
                let query = $('#search').val()
                checkProduct(query)
            }
        })
        let id
        function checkProduct(query){
            $.ajax({
                url: "{{route('live.search.product')}}",
                method: "GET",
                type: "json",
                data: {query:query},
                success: function(data){
                    let obj = JSON.parse(data)
                    if(obj.count === 0){
                        Toast.fire({
                            type: 'success',
                            title: 'No Product Found.'
                        })
                        document.getElementById("search").focus();
                        $('#search').val('')
                    }
                    else if(obj.count == 2){
                        $('#greaterThanOne .modal-body table tbody').html(obj.dataTable);
                        $('#greaterThanOne').modal('show');
                        $('#greaterThanOne .greaterThanOneBody tr').click(function(){
                            id = $(this).find('td:first').text();
                            console.log("this ID is from ttable modal: " + id);
                            $('#greaterThanOne').modal('hide');
                            $('#addQuantityModal').modal({ 
                                backdrop: 'static',
                                keyboard: false
                            },'show')
                        })
                    }
                    else{
                        $('#addQuantityModal').modal({ 
                            backdrop: 'static',
                            keyboard: false
                        },'show')
                        console.log(obj.product_id)
                        id =  obj.product_id
                    }
                }
            })
        }
        $('#addQuantityModal').on('shown.bs.modal',function(){
            $('#quantity').val('')
            $(this).find('[autofocus]').focus()
        })
        let addItemButton = document.getElementById('quantity');
        addItemButton.addEventListener("keyup",function(event){
            if(event.keyCode === 13){
                event.preventDefault();
                document.getElementById('add_item').click();
            } 
        });
        cancelItems = ()=> {
            product_info = [];
            total_price = [];
            $('.table-tbody').html('')
            $('#total').val('0.00')
            console.log('product_info deleted : ' + JSON.stringify(product_info))
            console.log('total sum deleted: ' + JSON.stringify(total_price))
        }
        $('body').on('click','.table-tbody tr',function(){
            var r = confirm("Are you sure you want to cancel this item?");
            if (r == true) {
                let row_index = $(this).closest("tr").index()
                console.log("row index:"+row_index)
                console.log("total_price[row_index]: " + total_price[row_index])
                index = total_price.indexOf(total_price[row_index])
                console.log("index: "+index)
                if (index >= 0) {
                    total_price.splice(index, 1);
                    product_info.splice(index,1)
                    $(this).closest("tr").remove()
                }
                console.log("remain object after delete: " + total_price)
                sum = total_price.reduce(function(a,b){
                    return a + b;
                },0)
                const formatter = new Intl.NumberFormat('en-PH',{
                    style: 'currency',
                    currency: 'PHP',
                    minimumFractionDigits: 2
                })
                $('.total_price input[type="text"]').val(formatter.format(sum))
            }
        })
    });
</script>
</html>