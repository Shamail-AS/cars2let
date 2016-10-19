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
                        <td>License#</td>
                        <td>DOB</td>
                        <td>Tel#</td>
                        <td>Registered Since</td>
                        {{--<td>Active car</td>--}}
                        <td>Active Contract</td>
                        <td>Total contracts</td>
                        <td>Total revenue (£)</td>
                        <td>Paid to Investor (£)</td>
                    </tr>
                    </thead>
                    <tbody>
                    {{--@foreach($drivers as $driver)--}}
                        {{--<tr>--}}
                            {{--<td><a href="{{ url('investor/drivers/'.$driver->id) }}">{{$driver->name}}</a></td>--}}
                            {{--<td>{{$driver->email}}</td>--}}
                            {{--<td>{{$driver->license_no}}</td>--}}
                            {{--<td>{{Carbon\Carbon::parse($driver->dob)->toFormattedDateString()}}</td>--}}
                            {{--<td>{{substr($driver->phone,0,12)}}</td>--}}
                            {{--<td>{{Carbon\Carbon::parse($driver->created_at)->toFormattedDateString()}}</td>--}}
                            {{--<td>{{$driver->currentContract->id or 'No active contract'}}</td>--}}
                            {{--<td>{{$driver->totalContracts}}</td>--}}
                            {{--<td>{{$driver->totalRevenue}}</td>--}}
                            {{--<td>{{$driver->totalPaid}}</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    <tr ng-repeat="driver in vm.drivers
                        | filter : {name : filters.search}">
                        <td><a href="{{ url('investor/drivers/')}}/@{{ driver.id }}">@{{ driver.name }}</a></td>
                        {{--<td>@{{ driver.email }}</td>--}}
                        <td>@{{ driver.license_no }}</td>
                        <td>@{{ driver.birth_date }}</td>
                        {{--<td>@{{ driver.tel }}</td>--}}
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
                        {{--<td></td>--}}
                        <td></td>
                        {{--<td></td>--}}
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

    <div class="fixed-footer-button-container">
        <div class="card-container">
            @include('partials.form.driver-create',['admin'=>false])
        </div>
{{--        <a class="fixed-footer-button" href="{{url('/investor/assets/create/driver')}}"><i class="fa fa-plus fa-3x"></i></a>--}}
        <a class="fixed-footer-button"><i class="fa fa-plus fa-3x"></i></a>
    </div>

    <script>
        $('.fixed-footer-button').click(function(e){
            $('.fixed-footer-button').toggleClass('clicked');
            $('.card-container').fadeToggle('fast');
        });

    </script>

@endsection


@section('scripts')

    <script src="{{asset('Areas/Assets/Driver/module.js')}}"></script>
    <script src="{{asset('Areas/Assets/Driver/factory.js')}}"></script>
    <script src="{{asset('Areas/Assets/Driver/controller.js')}}"></script>
    <script src="{{asset('Areas/Assets/Driver/filters.js')}}"></script>
@endsection