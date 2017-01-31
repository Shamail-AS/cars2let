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
                    <td>Weeks Available Since</td>
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
    <div class="card" >
        <div class="card-body">
            <h3>Car Detail</h3>
            <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form" action="{{url('investor/cars/'.$car->id.'/update_details')}}" method="post">
                                {!! csrf_field() !!}
                                <table class="table table-bordered responsive">
                                    <tbody>
                                        <tr>
                                            <td>Price</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='price' name="price" class="form-control" value="{{$car->price}}" />
                                                   @if ($errors->has('price')) <p class="help-block">{{ $errors->first('price') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PCO License No</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='pco_licence_no' name="pco_license_no" class="form-control" value="{{$car->pco_licence}}" />
                                                   @if ($errors->has('pco_license_no')) <p class="help-block">{{ $errors->first('pco_licence_no') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PCO Expires on </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='pco_expires_at' name="pco_expires_at" class="form-control" value="{{$car->pco_expires_at}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('pco_expires_at')) <p class="help-block">{{ $errors->first('pco_expires_at') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Warranty Expires on</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='warranty_exp_at' name="warranty_exp_at" class="form-control" value="{{$car->warranty_exp_at}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('warranty_exp_at')) <p class="help-block">{{ $errors->first('warranty_exp_at') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Roadside Assistance Expires on</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='roadside_exp_at' name="roadside_exp_at" class="form-control" value="{{$car->roadside_exp_at}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('roadside_exp_at')) <p class="help-block">{{ $errors->first('roadside_exp_at') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Roadside Assistance Expires on</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='road_tax_exp_at' name="road_tax_exp_at" class="form-control" value="{{$car->road_tax_exp_at}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('road_tax_exp_at')) <p class="help-block">{{ $errors->first('road_tax_exp_at') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered responsive">
                                    <tbody>
                                        <tr>
                                            <td>Model</td>
                                            <td>
                                                <input type='text' id='model' name="model" class="form-control" value="{{$car->model}}"/>
                                                @if ($errors->has('model')) <p class="help-block">{{ $errors->first('model') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Year</td>
                                            <td>
                                                <input type='text' id='year' name="year" class="form-control" value="{{$car->year}}"/>
                                                @if ($errors->has('year')) <p class="help-block">{{ $errors->first('year') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Transmission</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <select class="form-control" name="transmission" id="transmission">
                                                            <option @if($car->transmission == '') selected @endif value="">Select the transmission</option>
                                                            <option @if($car->transmission == 'automatic') selected @endif value="automatic">Automatic</option>
                                                            <option @if($car->transmission == 'semi-automatic') selected @endif value="semi-automatic">Semi Automatic</option>
                                                            <option @if($car->transmission == 'manual') selected @endif value="manual">Manual</option>
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('transmission')) <p class="help-block">{{ $errors->first('transmission') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fuel Type</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <select class="form-control" name="fuel_type" id="fuel_type">
                                                            <option @if($car->fuel_type == '') selected @endif value="">Select the Fuel Type</option>
                                                            <option @if($car->fuel_type == 'petrol') selected @endif value="petrol">Petrol</option>
                                                            <option @if($car->fuel_type == 'diesel') selected @endif value="diesel">Diesel</option>
                                                            <option @if($car->fuel_type == 'lpg') selected @endif value="lpg">Lpg</option>
                                                            <option @if($car->fuel_type == 'bio') selected @endif value="bio">Bio</option>
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('fuel_type')) <p class="help-block">{{ $errors->first('fuel_type') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Engine Size</td>
                                            <td>    
                                                <div class="form-group">
                                                   <input type='text' id='engine_size' name="engine_size" class="form-control" value="{{$car->engine_size}}" />
                                                   @if ($errors->has('engine_size')) <p class="help-block">{{ $errors->first('engine_size') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Chasis #</td>
                                            <td>
                                               <input type='text' id='chassis_num' name="chassis_num" class="form-control" value="{{$car->chasis_num}}" />
                                               @if ($errors->has('chassis_num')) <p class="help-block">{{ $errors->first('chassis_num') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Keeper</td>
                                            <td>
                                                <input type='text' id='keeper' name="keeper" class="form-control" value="{{$car->keeper}}" />
                                                @if ($errors->has('keeper')) <p class="help-block">{{ $errors->first('keeper') }}</p> @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered responsive">
                                    <tbody>
                                        <tr>
                                            <td>Custom Id</td>
                                            <td>    
                                                <input type='text' id='custom_id' name="custom_id" class="form-control" value="{{$car->custom_id}}" />
                                                @if ($errors->has('custom_id')) <p class="help-block">{{ $errors->first('custom_id') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>First Registration Date</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='first_reg_date' name="first_reg_date" class="form-control" value="{{$car->first_reg_date}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('first_reg_date')) <p class="help-block">{{ $errors->first('first_reg_date') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <center><input name="" class="btn btn-lg btn-success" value="Update" type="submit"></center>
                    </div>
                </div>
                </form>
            <div class="heading">
                <h4>*Subject to adjustments for VAT and other expenses</h4>
            </div>
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
                <input class="form-control" type="number" name="make" value="{{$car->make}}">
            </div>
            <div class="form-group ">
                <label>Available Since</label>
                <input class="form-control dp" type="date" name="available_since"
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
          $("#pco_expires_at").datetimepicker({format:"YYYY-MM-DD"});
          
          $("#warranty_exp_at").datetimepicker({format:"YYYY-MM-DD"});
          $("#roadside_exp_at").datetimepicker({format:"YYYY-MM-DD"});
          $("#road_tax_exp_at").datetimepicker({format:"YYYY-MM-DD"});
          $("#first_reg_date").datetimepicker({format:"YYYY-MM-DD"});
          $('[data-toggle="popover"]').popover();

        });
      </script>
@endsection