@extends('layouts.app')

@section('styles')

    <link href="{{ asset('css/sub_nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/investor_cars.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('partials.assets_subnav', ['drivers'=>'active'])

    <div class="wrapper" ng-app="cars2let" ng-controller = 'driverController'>
        <div class="search-container">
            <input class="form-control search-bar"
                   placeholder="Search drivers by name, email or license"
                    ng-model="filters.search">

        </div>
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>License #</td>
                        <td>PCO License #</td>
                        <td>DOB</td>
                        <td>Tel#</td>
                        <td>Registered Since</td>
                        <td>Active Contract</td>
                        <td>Total contracts</td>
                        <td>Total revenue (£)</td>
                        <td>Paid to Investor (£)</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="driver in vm.drivers
                        | driverFilter : filters.search">
                        <td><a href="{{ url('investor/drivers/')}}/@{{ driver.id }}">@{{ driver.name }}</a></td>
                        <td>@{{ driver.email }}</td>
                        <td>@{{ driver.license_no }}</td>
                        <td>@{{ driver.pco_license_no }}</td>
                        <td>@{{ driver.birth_date }}</td>
                        <td>@{{ driver.tel }}</td>
                        <td>@{{ driver.reg_since }}</td>
                        <td>@{{ driver.active_contract }}</td>
                        <td>@{{ driver.totalContracts }}</td>
                        <td>@{{ driver.totalRevenue }}</td>
                        <td>@{{ driver.totalPaid }}</td>
                    </tr>
                    </tbody>
                    <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>TOTAL</td>
                        <td>@{{ vm.sum.totalContracts }}</td>
                        <td>@{{ vm.sum.totalRevenue }}</td>
                        <td>@{{ vm.sum.totalPaid }}</td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>

@endsection


@section('scripts')

    <script src="{{asset('Areas/Assets/Driver/module.js')}}"></script>
    <script src="{{asset('Areas/Assets/Driver/factory.js')}}"></script>
    <script src="{{asset('Areas/Assets/Driver/controller.js')}}"></script>
    <script src="{{asset('Areas/Assets/Driver/filters.js')}}"></script>
@endsection