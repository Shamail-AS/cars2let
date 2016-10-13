@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/sub_nav.css')}}" rel="stylesheet">
    <link href="{{ asset('css/investor_car_details.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('partials.assets_subnav', ['cars'=>'active'])

    <div class="contract-details-table row">
        <div class="cell">
            <h1><a href="{{url("investor/cars")}}"><i class="fa fa-chevron-left"></i> All Cars</a></h1>
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
                        <button class="btn btn-xs btn-danger">Edit</button>
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

    <!--    <div class="card-container">
           <div class="card-container-vertical">
               @for($i = 0; $i < 5; $i++)
                   <div class="card">
                       <div class="tag-header {{$i == 0? 'ongoing' : 'complete'}}">
                           <p>Contract {{$i == 0? 'Ongoing' : 'Completed on '.$i.' June 2016'}}</p>
                       </div>
                       <div class="card-body">
                           <div class="contract">
                               <h3>Contract Overview</h3>
                               <table class="table table-bordered">

                                   <tr>
                                       <td>Start Date</td>
                                       <td>09/10/2016</td>

                                   </tr>
                                   <tr>
                                       <td>End Date</td>
                                       <td>10/11/2017</td>
                                   </tr>
                                   <tr>
                                       <td>Driver</td>
                                       <td>Adam Joshua</td>
                                   </tr>
                                   <tr>
                                       <td>Rent/Week</td>
                                       <td>$280</td>
                                   </tr>
                                   <tr>
                                       <td>Weeks completed</td>
                                       <td>4</td>
                                   </tr>
                                   <tr>
                                       <td>Gross Rent</td>
                                       <td>280 x 4</td>
                                   </tr>
                                   <tr>
                                       <td>Paid to Investor</td>
                                       <td>$2600</td>
                                   </tr>

                               </table>
                               <div class="heading">
                                   <h4>*Subject to adjustments for VAT and other expenses</h4>
                               </div>
                           </div>
                       </div>
                   </div>
               @endfor

            </div>

            <div class="card-container-vertical">
                <div class="card">
                    <div class="card-body">
                        <h3>Revenue Overview</h3>
                        <table class="table table-bordered">
                            <tr>
                                <th>       </th>
                                <th>Since Joining</th>
                                <th>For current accounting period</th>
                            </tr>
                            <tr>
                                <td>Investor Revenue</td>
                                <td>$400</td>
                                <td>$100</td>
                            </tr>
                            <tr>
                                <td>Paid to investor</td>
                                <td>$330</td>
                                <td>$90</td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td>$2600</td>
                                <td>$290</td>
                            </tr>
                        </table>
                        <div class="heading">
                            <h4>*Subject to adjustments for VAT and other expenses</h4>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="tag-header">
                        <p>Hello</p>
                    </div>
                    <div class="card-body">
                        <div class="contract">
                            <h3>Current Contract Overview</h3>
                            <table class="table table-bordered">

                                <tr>
                                    <td>Start Date</td>
                                    <td>09/10/2016</td>

                                </tr>
                                <tr>
                                    <td>End Date</td>
                                    <td>10/11/2017</td>
                                </tr>
                                <tr>
                                    <td>Driver</td>
                                    <td>Adam Joshua</td>
                                </tr>
                                <tr>
                                    <td>Rent/Week</td>
                                    <td>$280</td>
                                </tr>
                                <tr>
                                    <td>Weeks completed</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>Gross Rent</td>
                                    <td>280 x 4</td>
                                </tr>
                                <tr>
                                    <td>Paid to Investor</td>
                                    <td>$2600</td>
                                </tr>

                            </table>
                            <div class="heading">
                                <h4>*Subject to adjustments for VAT and other expenses</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>-->

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



@endsection