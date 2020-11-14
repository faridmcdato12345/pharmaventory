@extends('layouts.admin')
@section('content')
@include('includes.modal.report')
<div class="container-fluid pt-4">
    <div class="card">
        <div class="card-body">
            <div class="pb-4">
                <button type="button" class="btn btn-primary" id="add-days">Stock Expiring in Specific Number of Days</button>
            </div>
            <div class="pb-4">
                <a href="{{route('next.six.months')}}" class="btn btn-primary">Stock Expiring in the Next 6 Months</a>
            </div>
            <div class="pb-4">
                <button type="button" class="btn btn-primary" id="low-stock">Products Low in Stocks</button>
            </div>
            <div class="pb-4">
                <a href="{{route('out.of.stocks')}}" class="btn btn-primary">Out of Stock Products</a>
            </div>
            <div>
                <a href="{{route('stock.count')}}" type="button" class="btn btn-primary">Stock Count and Value Report</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
    let date = new Date();
    $('body').on('click','#add-days',function(e){
        $('#specific-days').modal('show')
    })
    $('body').on('click','#low-stock',function(e){
        $('#low-stock-modal').modal('show')
    })
    $('body').on('click','#ok',function(e){
        e.preventDefault();
        let numberDays = $('#days').val()
        let convertDaysToNumber = parseInt(numberDays)
        let day = date.getUTCDate() + convertDaysToNumber
        day = ("0" + day).slice(-2)
        let month = date.getUTCMonth() + 1;
        month = ("0" + month).slice(-2)
        let year = date.getUTCFullYear();
        let finalDate = year + "-" + month + "-" + day
        $.ajax({
            data: {exp:finalDate},
            url: "{{route('get.expiration.by.day')}}",
            type: "POST",
            dataType: "json",
            success: function(data){
                window.open("{{url('admin/report/inventory_report')}}/"+finalDate+"",'_self')
            },
            error: function(err){
                $('.modal-error-alert').show();
                $('.modal-error-alert').html('No product will expire on that day');
            }
        })
    })
    $('body').on('click','#low-stock-ok',function(e){
        e.preventDefault();
        let value = $('#stock').val()
        $.ajax({
            data: {val:value},
            url: "{{route('get.low.stock.value')}}",
            type: "POST",
            dataType: "json",
            success: function(data){
                window.open("{{url('admin/report/inventory_report/quantity')}}/"+value+"",'_self')
            },
            error: function(err){
                $('.modal-error-alert').show();
                $('.modal-error-alert').html('No product that is less than or equal to that value ');
            }
        })
    })
    $('body').on('click','#close-report-modal',function(e){
        e.preventDefault();
        $('#specific-days').find('form')[0].reset()
        $('#specific-days').modal('hide')
        $('#low-stock-modal').find('form')[0].reset()
        $('#low-stock-modal').modal('hide')
        $('.modal-error-alert').hide();
    })
})
</script>
@endsection