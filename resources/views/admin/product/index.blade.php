@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex">
                <div class="mr-2">
                    <a href="{{route('product.create')}}" class="btn btn-primary">Add Product</a>
                </div>
                <div>
                <a href="{{route('import.product')}}" class="btn btn-success">Import Excel</a>
                </div>
            </div>
            <div class="h-auto overflow-auto text-base card mt-4 p-1">
                <div class="card-body">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CATEGORY</th>
                                <th>BRAND</th>
                                <th>PRODUCT NAME</th>
                                <th>BARCODE</th>
                                <th>DESCRIPTION</th>
                                <th>PURCHASED PRICE</th>
                                <th>RESELL PRICE</th>
                                <th>QUANTITY</th>
                                <th>EXPIRATION DATE</th>
                                <th>POTENCY</th>
                                <th>FORM TYPE</th>
                                <th>PACKAGING</th> 
                                <th width="280px">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="product-tbody">
                            @foreach ($products as $product)
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->categories()->first()['name']}}</td>
                                <td>{{$product->brands()->first()['name']}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->barcode}}</td>
                                <td>{{$product->description}}</td>
                                <td> 
                                    @php
                                    $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                    $value = $product->purchased_price;
                                    $value = $value/100;
                                    $formatted = $amount->format($value); 
                                    @endphp
                                    {{$formatted}}
                                </td>
                                <td> 
                                    @php
                                    $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                                    $value = $product->retail_price;
                                    $value = $value/100;
                                    $formatted = $amount->format($value); 
                                    @endphp
                                    {{$formatted}}
                                </td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->expiration}}</td>  
                                <td>{{$product->potencies()->first()['name']}}</td>
                                <td>{{$product->types()->first()['name']}}</td>
                                <td>{{$product->packagings()->first()['name']}}</td>
                                <td class="text-nowrap">
                                    <a class="btn btn-info btn-sm editProduct" data-toggle="tooltip" data-original-title="Edit"> <i class="fas fa-pencil-alt text-white "></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            <form id="product_form" name="product_form">
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary updateProduct" data-dismiss="modal">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
          </div>
      
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        let table = $('#myTable').DataTable({
            stateSave: true,
            "scrollX": true,
        })
    })
    
    $('#DataTables_Table_0_wrapper .row:nth-child(1) .col-md-6:nth-child(1)').css('display','none')
    //$('<div class="row"><div class="col-sm-12 col-md-12"><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:</label><input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0"></div></div></div>').prependTo('#DataTables_Table_0_wrapper');
    $('input[type="search"]').css({'width':'1080px'}).attr('placeholder','Write here...')
</script>
<script>
    let productId;
    $('body').on('click','.editProduct',function(){
        let id = $(this).closest('tr').find('td:first').text()
        $.ajax({
            url: "{{route('edit.product')}}",
            type: "json",
            method: "GET",
            data: {
                product_id: id
            },
            success:function(data){
                let productObj = JSON.parse(data)
                console.log(data)
                $('.modal-body').html(productObj.product)
                productId = productObj.product_id
                $('#myModal').modal('show')
            }
        });
    })
    $('body').on('click','.updateProduct',function(e){
        e.preventDefault()
        let url = "{{route('update.product',':id')}}"
        url = url.replace(':id',productId)
        $.ajax({
            data: $('#product_form').serialize(),
            url: url,
            type: 'PATCH',
            dataType: 'json',
            success:function(data){
                table.draw()
            },
            error:function(err){

            }
        })
    })
</script>
@endsection