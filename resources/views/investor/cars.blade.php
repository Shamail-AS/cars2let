@extends('layouts.app')

@section('styles')

    <link href="{{ asset('css/sub_nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/investor_cars.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('partials.assets_subnav', ['cars'=>'active'])
    <div class="wrapper" ng-app="cars2let" ng-controller="carController">
        <div class="search-container">
            <input class="form-control search-bar"
                   placeholder="Search cars using Registration number"
                    ng-model="filters.car">

        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Reg #</td>
                <td>Make</td>
                <td>Available since</td>
                <td>Active Contract #</td>
                <td>Total contracts</td>
                <td>Total revenue (£)</td>
                <td>Paid to Investor (£)</td>
            </tr>
            </thead>
            <tbody>

            <tr ng-repeat="car in vm.cars | filter:{reg_no:filters.car}">
                <td><a href="{{ url('investor/cars')}}/@{{ car.id }}">@{{ car.reg_no }}</a></td>
                <td>@{{ car.make }}</td>
                <td>@{{ car.available }}</td>
                <td>@{{ car.currentContract.id || "No active contract" }}</td>
                <td>@{{ car.totalContracts }}</td>
                <td>@{{ car.totalRevenue }}</td>
                <td>@{{ car.totalRent }}</td>
            </tr>

            </tbody>

            <thead>
            <tr>
                <td></td>
                <td></td>
                <td>TOTAL</td>
                <td>@{{ vm.sum.totalContracts }}</td>
                <td>@{{ vm.sum.totalRevenue }}</td>
                <td>@{{ vm.sum.totalRent }}</td>
            </tr>
            </thead>
        </table>

        <div class="fixed-footer-button-container">
            <div class="card-container">
                @include('partials.form.car-create',['admin'=>false])
            </div>
            <div class="flex-container">
                <span class="fixed-footer-button"><i class="fa fa-plus fa-2x"></i></span>
            </div>
        </div>
    </div>

    <script>
        $('.fixed-footer-button').click(function () {
            $('.fixed-footer-button').toggleClass('clicked');
            $('.card-container').fadeToggle('fast');
        });

    </script>

@endsection

@section('scripts')

    <script src="{{asset('Areas/Assets/Car/module.js')}}"></script>
    <script src="{{asset('Areas/Assets/Car/factory.js')}}"></script>
    <script src="{{asset('Areas/Assets/Car/controller.js')}}"></script>
    <script src="{{asset('Areas/Assets/Car/filters.js')}}"></script>
@endsection