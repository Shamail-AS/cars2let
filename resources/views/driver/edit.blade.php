@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css">

@endsection
@section('scripts')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#start_date").datetimepicker({format:"YYYY-MM-DD"});
      $("#end_date").datetimepicker({
          useCurrent: false,
          format:"YYYY-MM-DD"
      });
      $("#start_date").on("dp.change", function (e) {
          $("#end_date").data("DateTimePicker").minDate(e.date);
      });
      $("#end_date").on("dp.change", function (e) {
          $("#start_date").data("DateTimePicker").maxDate(e.date);
      });
      $("#driving_licence_start_date").datetimepicker({format:"YYYY-MM-DD"});
      $("#dob").datetimepicker({format:"YYYY-MM-DD"});
      $("#driving_mini_cab_from").datetimepicker({format:"YYYY-MM-DD"});
      $("#pass_exp_at").datetimepicker({format:"YYYY-MM-DD"});
      $("#pco_expires_at").datetimepicker({format:"YYYY-MM-DD"});
      $("#licence_expires_at").datetimepicker({format:"YYYY-MM-DD"});
      $("#driving_since").datetimepicker({format:"YYYY-MM-DD"});
      $('[data-toggle="popover"]').popover();

    });
  </script>

@endsection
@section("content")
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h3>Edit Info</h3>
                    </div>
                </div>
                <br>
                <form method="post" action="{{ url('driver/update') }}">
                  {!! csrf_field() !!}
                <div class="list-group">
                    <a class="list-group-item list-group-item-action active">
                        <center><h4>Details</h4></center>
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered responsive">
                                    <tbody>
                                        <tr>
                                            <td>ID</td>
                                            <td>{{$driver->id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='name' name="name" class="form-control" value="{{$driver->name}}"/>
                                                   @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>License No</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='licence_no' name="license_no" class="form-control" value="{{$driver->license_no}}"/>
                                                   @if ($errors->has('licence_no')) <p class="help-block">{{ $errors->first('licence_no') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PCO License No</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='pco_licence_no' name="pco_license_no" class="form-control" value="{{$driver->pco_license_no}}"/>
                                                   @if ($errors->has('pco_licence_no')) <p class="help-block">{{ $errors->first('pco_licence_no') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <input type='text' id='email' name="email" class="form-control" value="{{$driver->email}}"/>
                                                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>
                                                <input type='text' id='phone' name="phone" class="form-control" value="{{$driver->phone}}"/>
                                                @if ($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date Of Birth</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='dob' name="dob" class="form-control" value="{{$driver->dob}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('dob')) <p class="help-block">{{ $errors->first('dob') }}</p> @endif
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
                                            <td>Address</td>
                                            <td>
                                                <div class="form-group">
                                                   <input type='text' id='address' name="address" class="form-control" value="{{$driver->address}}"/>
                                                   @if ($errors->has('address')) <p class="help-block">{{ $errors->first('address') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alternative Address</td>
                                            <td>
                                                <div class="form-group">
                                                   <input type='text' id='alt_address' name="alt_address" class="form-control" value="{{$driver->alt_address}}"/>
                                                   @if ($errors->has('alt_address')) <p class="help-block">{{ $errors->first('alt_address') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Passport</td>
                                            <td>
                                               <input type='text' id='passport' name="passport" class="form-control" value="{{$driver->passport}}"/>
                                               @if ($errors->has('passport')) <p class="help-block">{{ $errors->first('passport') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Passport Expiry At</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='pass_exp_at' name="pass_exp_at" class="form-control" value="{{$driver->pass_exp_at}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('pass_exp_at')) <p class="help-block">{{ $errors->first('pass_exp_at') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nationality</td>
                                            <td>
                                                <input type='text' id='nationality' name="nationality" class="form-control" value="{{$driver->nationality}}"/>
                                                @if ($errors->has('nationality')) <p class="help-block">{{ $errors->first('nationality') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Person</td>
                                            <td>    
                                                <input type='text' id='emerg_person' name="emerg_person" class="form-control" value="{{$driver->emerg_person}}"/>
                                                @if ($errors->has('emerg_person')) <p class="help-block">{{ $errors->first('emerg_person') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Number</td>
                                            <td>
                                                <input type='text' id='emerg_num' name="emerg_num" class="form-control" value="{{$driver->emerg_num}}"/>
                                                @if ($errors->has('emerg_num')) <p class="help-block">{{ $errors->first('emerg_num') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Years living in the Uk</td>
                                            <td>    
                                                <input type='text' id='years_in_uk' name="years_in_uk" class="form-control" value="{{$driver->years_in_uk}}"/>
                                                @if ($errors->has('years_in_uk')) <p class="help-block">{{ $errors->first('years_in_uk') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PCO Expires on </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='pco_expires_at' name="pco_expires_at" class="form-control" value="{{$driver->pco_expires_at}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('pco_expires_at')) <p class="help-block">{{ $errors->first('pco_expires_at') }}</p> @endif
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
                                            <td>License Expiry At</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='licence_expires_at' name="licence_expires_at" class="form-control" value="{{$driver->licence_expires_at}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('licence_expires_at')) <p class="help-block">{{ $errors->first('licence_expires_at') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>
                                                <input type='text' id='type' name="type" class="form-control" value="{{$driver->type}}"/>
                                                @if ($errors->has('type')) <p class="help-block">{{ $errors->first('type') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>National Insurance Number</td>
                                            <td>
                                                <input type='text' id='nino' name="nino" class="form-control" value="{{$driver->nino}}"/>
                                                @if ($errors->has('nino')) <p class="help-block">{{ $errors->first('nino') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Right to Work</td>
                                            <td>
                                                <input type='text' id='right_to_work' name="right_to_work" class="form-control" value="{{$driver->right_to_work}}"/>
                                                @if ($errors->has('right_to_work')) <p class="help-block">{{ $errors->first('right_to_work') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Driving Since</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='driving_since' name="driving_since" class="form-control" value="{{$driver->driving_since}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('driving_since')) <p class="help-block">{{ $errors->first('driving_since') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Driving Licence Start Date</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='driving_licence_start_date' name="driving_licence_start_date" class="form-control" value="{{$driver->driving_licence_start_date}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('driving_licence_start_date')) <p class="help-block">{{ $errors->first('driving_licence_start_date') }}</p> @endif
                                                </div>  
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Driving Minicab From</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='driving_mini_cab_from' name="driving_mini_cab_from" class="form-control" value="{{$driver->driving_mini_cab_from}}" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                    @if ($errors->has('driving_mini_cab_from')) <p class="help-block">{{ $errors->first('driving_mini_cab_from') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Uber Rating</td>
                                            <td>
                                                <input type='text' id='uber_rating' name="uber_rating" class="form-control" value="{{$driver->uber_rating}}"/>
                                                @if ($errors->has('uber_rating')) <p class="help-block">{{ $errors->first('uber_rating') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Penelty Points</td>
                                            <td>
                                                <input type='text' id='penalty_points' name="penalty_points" class="form-control" value="{{$driver->penalty_points}}"/>
                                                @if ($errors->has('penalty_points')) <p class="help-block">{{ $errors->first('penalty_points') }}</p> @endif
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
                        <center><input name="" value="save" class="btn btn-success btn-lg" type="submit"></center>
                    </div>
                </div>
            </form>     
            </div>
        </div>
    </div>
@endsection
