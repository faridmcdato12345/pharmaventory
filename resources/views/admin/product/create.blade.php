@extends('layouts.admin')
@section('content')
<div class="container-fluid pt-4">
    @include('includes.alerts')
    <div class="card">
        <div class="card-body">            
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div>
                        <form id="product-form" name="product-form">
                            <div class="row pt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="barcode">Barcode:</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <input type="text" name="description" id="description" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="text" name="quantity" id="quantity" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="purchased_price">Purchased Price:</label>
                                        <input type="text" name="purchase_price" id="purchased_price" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="resell_price">Resell Price:</label>
                                        <input type="text" name="retail_price" id="resell_price" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="storage">Storage Location:</label>
                                        <select name="storage_id" id="storage" class="form-control types">
                                            <option value="">---Select storage here---</option>
                                            @foreach ($storages as $storage)
                                                <option value="{{$storage->id}}">{{$storage->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiration">Expiration Date:</label>
                                        <input type="date" name="expiration" id="expiration" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type:</label>
                                        <div class="row">
                                            <div class="col-sm-9 pr-0">
                                                <select name="type_id" id="type" class="form-control types">
                                                    <option value="">---Select attribute here---</option>
                                                @foreach ($types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary form-control manage" id="types">Manage</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="potency">Potency:</label>
                                        <div class="row">
                                            <div class="col-sm-9 pr-0">
                                                <select name="potency_id" id="potency" class="form-control potencies">
                                                    <option value="">---Select attribute here---</option>
                                                @foreach ($potencies as $potency)
                                                    <option value="{{$potency->id}}">{{$potency->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary form-control manage" id="potencies">Manage</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="packaging">Packaging:</label>
                                        <div class="row">
                                            <div class="col-sm-9 pr-0">
                                                <select name="packaging_id" id="packaging" class="form-control packagings">
                                                    <option value="">---Select attribute here---</option>
                                                @foreach ($packagings as $packaging)
                                                    <option value="{{$packaging->id}}">{{$packaging->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary form-control manage" id="packagings">Manage</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="brand">Brand:</label>
                                        <div class="row">
                                            <div class="col-sm-9 pr-0">
                                                <select name="brand_id" id="brand" class="form-control brands">
                                                    <option value="">---Select attribute here---</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary form-control manage" id="brands">Manage</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category:</label>
                                        <div class="row">
                                            <div class="col-sm-9 pr-0">
                                                <select name="category_id" id="category" class="form-control categories">
                                                    <option value="">---Select attribute here---</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary form-control manage" id="categories">Manage</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                        <input type="submit" name="addProduct" value="Add Product" class="btn btn-primary addProduct w-32">
                        <a href="{{route('product.index')}}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
    
    let route = "{{route('get.all.types')}}"
    $('body').on('click','.manage',function(e){
        e.preventDefault();
        let id = $(this).attr('id')
        let routes = route.replace('types',id);
        $('#product-attribute-manage label').attr("for",id)
        $('#product-attribute-manage form').attr({id:id,name:id})
        $('#product-attribute-manage .modal-title').html(id.toUpperCase())
        $('#product-attribute-manage form input[type="text"]').attr({name: id,id: id})
        $('#product-attribute-manage .function-button button.update').attr("id",id)
        $('#product-attribute-manage tbody').html('');
        $.get(routes,function(data){
            data.forEach(element => {
                $('#product-attribute-manage tbody').append("<tr><td>"+element.name+"</td></tr>")
            });
        })
        $('#product-attribute-manage').modal('show')
    })
    $('body').on('click','.update',function(e){
        e.preventDefault();
        let id = $(this).attr('id')
        let route = "{{route('types.store')}}"
        let routes = route.replace('types',id);
        $.ajax({
            data:{name: $('.inputted').val()},
            url: routes,
            type: "POST",
            dataType: "json",
            success:function(data){
                $('.attribute_modal').html(data.attribute)
                console.log(data.data)
                if(data.model == 'types'){
                    $('select.types').html(data.data)
                }
                if(data.model == 'potencies'){
                    $('select.potencies').html(data.data)
                }
                if(data.model == 'packagings'){
                    $('select.packagings').html(data.data)
                }
                if(data.model == 'brands'){
                    $('select.brands').html(data.data)
                }
                if(data.model == 'categories'){
                    $('select.categories').html(data.data)
                }
                $('#product-attribute-manage').find('form')[0].reset()
            },
            error: function(err){
                $('.modal-succes-error').show('show');
                $('.modal-success-alert').html('Something went wrong!');
            }
        })
    })
    $('body').on('click','.closeModal',function(e){
        e.preventDefault();
        $('#product-attribute-manage').find('form')[0].reset()
        $('.modal-success-alert').hide();
        $('#product-attribute-manage').modal('hide')
    })
    document.getElementById("barcode").focus();
    $('#cancel').on('click',function(e){
        window.history.back();
    })
    $('body').on('click','.addProduct',function(e){
        e.preventDefault();
        $.ajax({
            data: $('#product-form').serialize(),
            url: "{{route('product.store')}}",
            type: "POST",
            dataType: "json",
            success: function(data){
                $('#product-form')[0].reset();
                $('.success-alert').show('slow');
                $('.success-alert').html(data.data.name + ' is successfully saved');
            },
            error: function(err){
                $('.succes-error').show('show');
                $('.success-alert').html('Something went wrong!');
            }
        });
    });
})
</script>
@endsection