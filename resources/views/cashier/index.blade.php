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
        .total_sum{
            font-size: 100px !important;
            text-align: left;
        }
        .card.payment,.card.change{
            min-height:100px;
            height:120px;
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
        .card.payment #payment,.card.change #change{
            font-size: 35px;
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
        <div class="row pt-2 pb-2 h-100">
            <div class="col-md-9 pr-0 h-75 relative block">
                <div class="card h-full">
                    <div class="card-body">
                        <div class="row h-25">
                            <div class="col-md-8">
                                <h3 class="text-dark text-center display-3 mb-1 font-weight-bold">PHARMAVENTORY</h3>
                                <hr>
                                <p class="text-dark h-5 text-center">Point of Sale & Inventory Management System</p>
                            </div>
                            <div class="col-md-4 bg-dark d-flex justify-content-center align-items-center border border-success rounded ">
                                <h1 class="text-success display-4 font-weight-bold timers" id="txt"></h1>
                            </div>
                        </div>
                        <div class="row text-black bg-gray-600 relative h-75 p-2 mt-2 overflow-hidden overflow-y-hidden">
                            <div class="pt-2 relative w-full text-gray-600">
                                <input id="search" class="form-control border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none"
                                  type="search" name="search" placeholder="Search" autofocus>
                                <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                                  <li class="fas fa-search"></li>
                                </button>
                            </div>
                            <div class="w-full product-table h-75 relative overflow-scroll">
                                <table class="table-fixed sticky-table">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2">NO</th>
                                            <th class="px-4 py-2">CATEGORY</th>
                                            <th class="px-4 py-2">BRAND</th>
                                            <th class="px-4 py-2">PRODUCT NAME</th>
                                            <th class="px-4 py-2">BARCODE</th>
                                            <th class="px-4 py-2">DESCRIPTION</th>
                                            <th class="px-4 py-2">PURCHASED PRICE</th>
                                            <th class="px-4 py-2">RESELL PRICE</th>
                                            <th class="px-4 py-2">QUANTITY</th>
                                            <th class="px-4 py-2">EXPIRATION DATE</th>
                                            <th class="px-4 py-2">POTENCY</th>
                                            <th class="px-4 py-2">FORM TYPE</th>
                                            <th class="px-4 py-2">PACKAGING</th>
                                        </tr>
                                    </thead>
                                    <tbody class="relative mt-24 table-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card h-25 mb-0 mt-1 total_price bg-black text-success font-weight-bold">
                    <div class="card-body">
                        <h1 class='total_sum'>P 0.00</h1> 
                    </div>
                </div>
            </div>
            <div class="col-md-3 pl-1 position-relative">
                <div class="card h-100 m-0 max-h-screen min-h-screen">
                    <div class="card-body pl-1 pr-1">
                        <div class="flex">
                            @if(Auth::user()->role_id == 1)
                            <div class="btn btn-warning form-control h-auto" id="return">
                                <i class="fa fa-arrow-left"></i>
                                <p class="mb-0">BACK</p>
                            </div>
                            @endif
                            <div class="btn btn-success form-control h-auto mx-2">
                                <i class="fa fa-redo"></i>
                                <p class="mb-0">REFRESH</p>
                            </div>
                            <div class="">
                                <a href="{{ route('logout') }}" class="text-white btn btn-danger form-control h-auto" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-times"></i>
                                <p class="mb-0">LOGOUT</p>
                                </a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                        <div class="card mt-4 h-50 text-black overflow-scroll">
                            <div class="card-body ">
                                <table class="w-full text-center invoice-table">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card payment text-success bg-dark">
                            <div class="card-body p-1">
                                <label for="payment">PAYMENT:</label>
                            </div>
                            <input type="text" name="payment" value="0.00" id="payment" class="form-control font-extrabold" autofocus>
                        </div>
                        <div class="card change text-success bg-dark">
                            <div class="card-body p-1">
                                <label for="change">CHANGE:</label>
                            </div>
                            
                            <input type="text" name="change" value="0.00" id="change" class="form-control font-extrabold" disabled>
                        </div>
                        <div class="paid_button">
                            <button type="button" class="form-control h-auto btn btn-primary">PAID(f2)</button>
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
                <input type="text" name="quantity" id="quantity" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary add_item" data-dismiss="modal">Add Item</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        let product_obj_id = [];
        let total_price = [];
        let sum,payment;
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
        fetchProduct();
        let id
        function fetchProduct(query = ''){
            $.ajax({
                url: "{{route('live.search.product')}}",
                method: "GET",
                type: "json",
                data: {query:query},
                success: function(data){
                    let obj = JSON.parse(data)
                    $('.table-tbody').html(obj.dataTable)
                    $(".sticky-table > .table-tbody > .clickable-row").click(function() {
                        id = $(this).closest('tr').find('td:first').text()
                        let name = $(this).closest('tr').find('td:nth-child(4)').text()
                        let barcode = $(this).closest('tr').find('td:nth-child(5)').text()
                        showModal(id,name,barcode)
                    });
                }
            })
        }
        $(document).on('keyup','#search',function(){
            let query = $(this).val()
            fetchProduct(query)
        })
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
        $('body').on('click','.paid_button button',function(){
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
                        location.reload()
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
                $('#change').val(change)
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
                    total_price.push(obj.total_price)
                    $('.invoice-table tbody').append(obj.item)
                    product_info.push({
                        "product_id":obj.product_id,
                        "quantity":obj.quantity,
                        "invoice_number":invoice
                    })
                    sum = total_price.reduce(function(a,b){
                        return a + b;
                    },0)
                    $('.total_price .card-body').html("<h1 class='total_sum'>P "+sum.toFixed(2)+"</h1>")
                    $("#myModal").modal('hide') 
                    $('#quantity').val('')
                    document.getElementById("search").focus();
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
    })
</script>
</html>