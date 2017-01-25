@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/sub_nav.css')}}" rel="stylesheet">
    <link href="{{ asset('css/investor_car_details.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('partials.assets_subnav', ['drivers'=>'active'])

    <div class="contract-details-table row">
        <div class="cell">
            <a href="{{url("investor/drivers")}}"><i class="fa fa-chevron-circle-left fa-4x"></i></a>
        </div>
        <div class="cell">
            <h1>{{$driver->name}}</h1>
        </div>
        <div class="cell bordered">
            <table class="table ">
                <thead>
                <tr>
                    <td>License</td>
                    <td>Email</td>
                    <td>Tel#</td>
                    <td>Age</td>
                    <td>Registered Since</td>
                    <td>Total Contracts</td>
                    <td>Total Revenue (£)</td>
                    <td>Paid to investor (£)</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$driver->license_no}}</td>
                    <td>{{$driver->email}}</td>
                    <td>{{($driver->phone)}}</td>
                    <td>{{$driver->age}} years</td>
                    <td>{{ Carbon\Carbon::parse($driver->created_at)->toFormattedDateString() }}</td>
                    <td>{{$driver->totalContracts}}</td>
                    <td>{{$driver->totalRevenue}}</td>
                    <td>{{$driver->totalPaid}}</td>

                </tr>
                </tbody>
            </table>
        </div>

    </div>
    <div id="cardDetails" class="card" >
        <div class="card-body">
            <h3>Revenue Overview</h3>
            <table class="table table-bordered">
                <tr>
                    <th>       </th>
                    <th>Since Joining</th>
                    <th>For current accounting period </th>
                    {{--ASSUMPTION  current month &&  only completed weeks--}}
                </tr>
                <tr>
                    <td>Investor Revenue (£)</td>
                    <td>{{$driver->totalRevenue}}</td>
                    <td>{{$driver->totalRevenueForCurrentPeriod}}</td>
                </tr>
                <tr>
                    <td>Paid to investor (£)</td>
                    <td>{{$driver->totalPaid}}</td>
                    <td>{{$driver->totalPaidForCurrentPeriod}}</td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td>{{$driver->totalRevenue - $driver->totalPaid}}</td>
                    <td>{{$driver->totalRevenueForCurrentPeriod - $driver->totalPaidForCurrentPeriod}}</td>
                </tr>
            </table>
            <div class="heading">
                <h4>*Subject to adjustments for VAT and other expenses</h4>
            </div>
        </div>
    </div>


    <div class="contract-details-table">
        <div class="cell row">
            <h3>Contracts</h3>
            <div class="cell bordered row padded">
                <p>Key : </p>
                <i class="fa fa-circle ongoing"></i><p>Ongoing</p>
                <i class="fa fa-circle complete"></i><p>Completed</p>
                <i class="fa fa-circle terminated"></i><p>Terminated</p>
                <i class="fa fa-circle suspended"></i><p>Suspended</p>
            </div>
        </div>

        <div class="cell bordered">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Status</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                    <td>Driver</td>
                    <td>Rent/week (£)</td>
                    <td>Weeks done/total</td>
                    <td>Revenue (£)</td>
                    <td>Paid to Investor (£)</td>
                    <td> </td>
                </tr>
                </thead>
                <tbody>

                @foreach($driver->investorContracts as $contract)
                    <tr>
                        @if($contract->status==1)
                            <td><i class="fa fa-circle ongoing"></i></td>
                        @elseif($contract->status==2)
                            <td><i class="fa fa-circle suspended"></i></td>
                        @elseif($contract->status == 3)
                            <td><i class="fa fa-circle terminated"></i></td>
                        @else
                            <td><i class="fa fa-circle complete"></i></td>

                        @endif
                        <td>{{$contract->start_date->toFormattedDateString()}}</td>
                        <td>{{$contract->end_date->toFormattedDateString()}}</td>
                        <td>{{$contract->driver->name}} ({{$contract->driver->license_no}})</td>

                        <td>{{$contract->rate}}</td>
                        <td>{{$contract->weeksDone}}/{{$contract->weeksTotal}}</td>
                        <td>{{$contract->revenue}}</td>
                        <td>{{$contract->rent}}</td>
                        <td><a href="{{url('/investor/contracts/'.$contract->id)}}" class="btn btn-xs btn-info">View</a> </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection