@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/sub_nav.css')}}" rel="stylesheet">
    <link href="{{asset('css/modal.css')}}" rel="stylesheet">
    <link href="{{ asset('css/investor_car_details.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('partials.assets_subnav', ['cars'=>'active'])

    <div class="contract-details-table row">
        <div class="cell">
            <a href="{{url("investor/cars")}}"><i class="fa fa-chevron-circle-left fa-4x"></i></a>
        </div>
        <div class="cell">
            <h1>{{$car->reg_no}}</h1>
        </div>
        <div class="cell bordered">
            <table class="table ">
                <thead>
                <tr>
                    <td>Make</td>
                    <td>Date Available Since</td>
                    <td>Total Contracts</td>
                    <td>Total Weeks</td>
                    <td>Total Revenue (£)</td>
                    <td>Paid to investor (£)</td>
                    <td> </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$car->make}}</td>
                    <td>{{ Carbon\Carbon::parse($car->available_since)->toFormattedDateString() }}</td>
                    <td>{{$car->totalContracts}}</td>
                    <td>{{$car->totalWeeks}}</td>
                    <td>{{$car->totalRevenue}}</td>
                    <td>{{$car->totalRent}}</td>
                    <td>
                        {{--<button class="btn btn-xs btn-success" onclick="$('#cardDetails').slideToggle('fast')">Details</button>--}}
                        <a id="modaltrigger" href="#loginmodal" class="btn btn-xs btn-danger" onclick="edit()">Edit</a>
                    </td>
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
                    <td>{{$car->totalRevenue}}</td>
                    <td>{{$car->totalRevenueForCurrentPeriod}}</td>
                </tr>
                <tr>
                    <td>Paid to investor (£)</td>
                    <td>{{$car->totalRent}}</td>
                    <td>{{$car->totalRentForCurrentPeriod}}</td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td>{{$car->totalRevenue - $car->totalRent}}</td>
                    <td>{{$car->totalRevenueForCurrentPeriod - $car->totalRentForCurrentPeriod}}</td>
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

                @foreach($car->contracts as $contract)

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

    <div id="loginmodal" style="display:none;">
        <form class="form" id="loginform" name="loginform" method="post"
              action="{{url('/investor/cars/'.$car->id.'/update')}}">
            {!! csrf_field() !!}
            <input type="hidden" value="{{$car->id}}" name="id">

            <div class="form-group">
                <label>Registration No</label>
                <input class="form-control" type="text" name="reg_no" value="{{$car->reg_no}}">
            </div>

            <div class="form-group">
                <label>Make</label>
                <input class="form-control" type="text" name="make" value="{{$car->make}}">
            </div>
            <div class="form-group ">
                <label>Available Since</label>
                <input class="form-control dp" type="text" name="available_since"
                       value="{{$car->available_since}}">
            </div>
            <div class="form-group">
                <label>Comments</label>
                <input class="form-control" type="text" name="comments"
                       value="{{$car->comments}}">
            </div>
            <div class="center">
                <input type="submit" name="loginbtn" id="loginbtn" class="flatbtn-blu hidemodal" value="Update"
                       tabindex="3">
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $().ready(function () {
            $('#modaltrigger').leanModal({top: 110, overlay: 0.45, closeButton: ".hidemodal"});
        });

    </script>
@endsection