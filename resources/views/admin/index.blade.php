@extends('layouts.admin')
@section('content')
<div class="container pt-2">
    <div class="card">
        <div class="card-body">
            <h4>User Overview</h4>
            <div class="row">
                <div class="col-sm-6">
                    <label for="username">Username:</label>
                <button class="btn btn-success text-lg font-bold pt-2">{{Auth::user()->username}}</button>
                </div>
                <div class="col-sm-6">
                    <label for="user_role">User role:</label>
                    <button class="btn btn-success text-lg font-bold pt-2">{{Auth::user()->roles->name}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Sales Overview</h4>
            <div class="row">
                <div class="col-sm-4">
                    <label for="current_sales">Current day sales:</label>
                    <button class="btn btn-primary text-lg font-bold">
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $formatted = $amount->format($nowPrice);
                        @endphp
                        {{$formatted}}</button>
                </div>
                <div class="col-sm-4">
                    <label for="yesterday_sales">Yesterday Sales:</label>
                    <button class="btn btn-primary text-lg font-bold">
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $formatted = $amount->format($yesterdayPrice);
                        @endphp
                        {{$formatted}}
                    </button>
                </div>
                <div class="col-sm-4">
                    <label for="weekly_sales">This week Sales:</label>
                    <button class="btn btn-primary text-lg font-bold">
                        @php
                        $amount = new \NumberFormatter("en_PH",\NumberFormatter::CURRENCY);
                        $formatted = $amount->format($thisWeekPrice);
                        @endphp
                        {{$formatted}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection