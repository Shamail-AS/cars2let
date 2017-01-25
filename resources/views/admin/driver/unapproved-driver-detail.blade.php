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
                        <h3>Driver Details </h3>
                    </div>
                    <div class="col-md-4">
                        <h3><a href="{{url('/admin/contracts/'.$contract->id.'/approve')}}" class="btn btn-danger pull-right">Approve Driver</a></h3>
                    </div>
                    <div class="col-md-4">
                        <h3><a href="{{url('/admin/contracts/'.$contract->id.'/pdf')}}" class="btn btn-success pull-right">Download Pdf</a></h3>
                    </div>
                </div>
                <br>
                <form method="post" action="{{ url('admin/contracts/'.$contract->id.'/update') }}">
                  {!! csrf_field() !!}
                <div class="list-group">
                    <a class="list-group-item list-group-item-action active">
                        <center><h4>Contract Information</h4></center>
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered responsive">
                                    <tbody>
                                        <tr>
                                            <td>Start Date</td>
                                            <td>
                                              <div class="form-group">
                                                  <div class='input-group date'>
                                                      <input type='text' id='start_date' name="start_date" class="form-control" value="{{$contract->start_date}}" />
                                                      <span class="input-group-addon">
                                                          <span class="glyphicon glyphicon-calendar"></span>
                                                      </span>
                                                  </div>
                                                  @if ($errors->has('start_date')) <p class="help-block">{{ $errors->first('start_date') }}</p> @endif
                                              </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>End Date</td>
                                            <td>
                                              <div class="form-group">
                                                <div class='input-group date'>
                                                    <input type='text' id='end_date' name="end_date" class="form-control" value="{{$contract->end_date}}" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                                @if ($errors->has('end_date')) <p class="help-block">{{ $errors->first('end_date') }}</p> @endif
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td>Rate</td>
                                            <td>{{$contract->rate}}</td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>{{$contract->currrency}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group">
                    <a class="list-group-item list-group-item-action active">
                        <center><h4>Driver Details</h4></center>
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
                                            <td>{{$contract->driver->id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='name' name="name" class="form-control" value="{{$contract->driver->name}}"/>
                                                   @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>License No</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='licence_no' name="licence_no" class="form-control" value="{{$contract->driver->licence_no}}"/>
                                                   @if ($errors->has('licence_no')) <p class="help-block">{{ $errors->first('licence_no') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PCO License No</td>
                                            <td>
                                              <div class="form-group">
                                                   <input type='text' id='pco_licence_no' name="pco_licence_no" class="form-control" value="{{$contract->driver->pco_licence_no}}"/>
                                                   @if ($errors->has('pco_licence_no')) <p class="help-block">{{ $errors->first('pco_licence_no') }}</p> @endif
                                               </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>
                                                <input type='text' id='email' name="email" class="form-control" value="{{$contract->driver->email}}"/>
                                                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>
                                                <input type='text' id='phone' name="phone" class="form-control" value="{{$contract->driver->phone}}"/>
                                                @if ($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date Of Birth</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='dob' name="dob" class="form-control" value="{{$contract->driver->dob}}" />
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
                                                   <input type='text' id='address' name="address" class="form-control" value="{{$contract->driver->address}}"/>
                                                   @if ($errors->has('address')) <p class="help-block">{{ $errors->first('address') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alternative Address</td>
                                            <td>
                                                <div class="form-group">
                                                   <input type='text' id='alt_address' name="alt_address" class="form-control" value="{{$contract->driver->alt_address}}"/>
                                                   @if ($errors->has('alt_address')) <p class="help-block">{{ $errors->first('alt_address') }}</p> @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Passport</td>
                                            <td>
                                               <input type='text' id='passport' name="passport" class="form-control" value="{{$contract->driver->passport}}"/>
                                               @if ($errors->has('passport')) <p class="help-block">{{ $errors->first('passport') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Passport Expiry At</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='pass_exp_at' name="pass_exp_at" class="form-control" value="{{$contract->driver->pass_exp_at}}" />
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
                                                <input type='text' id='nationality' name="nationality" class="form-control" value="{{$contract->driver->nationality}}"/>
                                                @if ($errors->has('nationality')) <p class="help-block">{{ $errors->first('nationality') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Person</td>
                                            <td>    
                                                <input type='text' id='emerg_person' name="emerg_person" class="form-control" value="{{$contract->driver->emerg_person}}"/>
                                                @if ($errors->has('emerg_person')) <p class="help-block">{{ $errors->first('emerg_person') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Number</td>
                                            <td>
                                                <input type='text' id='emerg_num' name="emerg_num" class="form-control" value="{{$contract->driver->emerg_num}}"/>
                                                @if ($errors->has('emerg_num')) <p class="help-block">{{ $errors->first('emerg_num') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Years living in the Uk</td>
                                            <td>    
                                                <input type='text' id='years_in_uk' name="years_in_uk" class="form-control" value="{{$contract->driver->years_in_uk}}"/>
                                                @if ($errors->has('years_in_uk')) <p class="help-block">{{ $errors->first('years_in_uk') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PCO Expires on </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='pco_expires_at' name="pco_expires_at" class="form-control" value="{{$contract->driver->pco_expires_at}}" />
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
                                                        <input type='text' id='licence_expires_at' name="licence_expires_at" class="form-control" value="{{$contract->driver->licence_expires_at}}" />
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
                                                <input type='text' id='type' name="type" class="form-control" value="{{$contract->driver->type}}"/>
                                                @if ($errors->has('type')) <p class="help-block">{{ $errors->first('type') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>National Insurance Number</td>
                                            <td>
                                                <input type='text' id='nino' name="nino" class="form-control" value="{{$contract->driver->nino}}"/>
                                                @if ($errors->has('nino')) <p class="help-block">{{ $errors->first('nino') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Right to Work</td>
                                            <td>
                                                <input type='text' id='right_to_work' name="right_to_work" class="form-control" value="{{$contract->driver->right_to_work}}"/>
                                                @if ($errors->has('right_to_work')) <p class="help-block">{{ $errors->first('right_to_work') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Driving Since</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class='input-group date'>
                                                        <input type='text' id='driving_since' name="driving_since" class="form-control" value="{{$contract->driver->driving_since}}" />
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
                                                        <input type='text' id='driving_licence_start_date' name="driving_licence_start_date" class="form-control" value="{{$contract->driver->driving_licence_start_date}}" />
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
                                                        <input type='text' id='driving_mini_cab_from' name="driving_mini_cab_from" class="form-control" value="{{$contract->driver->driving_mini_cab_from}}" />
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
                                                <input type='text' id='uber_rating' name="uber_rating" class="form-control" value="{{$contract->driver->uber_rating}}"/>
                                                @if ($errors->has('uber_rating')) <p class="help-block">{{ $errors->first('uber_rating') }}</p> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Penelty Points</td>
                                            <td>
                                                <input type='text' id='penalty_points' name="penalty_points" class="form-control" value="{{$contract->driver->penalty_points}}"/>
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
                <div style="margin-top:20px;" class="list-group">
                    <a class="list-group-item list-group-item-action active">
                        <center><h4>Driver Files</h4></center>
                    </a>

                </div>
                <div class="row">
                    <div class="col-md-12">
                      <table class="table">
                        <tbody>
                        @forelse($contract->driver->files as $file)
                            <tr>
                                @if($file->type == 'image')
                                <td>
                                    <img style="display: inline-block;" class="img-responsive" src="{{$file->full_url}}" width="100">
                                    <a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                     <button type="button" class="btn btn-danger pull-right" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-trigger="focus" title="Warning!"
                                        data-content='<p>Are you sure you want to proceed?</p>
                                            <a href="{{url('admin/driver/'.$contract->driver->id.'/file/'.$file->id)}}" class="btn btn-danger">Yes</a>
                                            <span class="btn btn-default">No</span>
                                        </form>
                                    '><i class="entypo-cancel"></i>Delete</button>
                                </td>
                            </tr>
                                @else
                                    <td>
                                        <p style="display: inline-block;">{{$file->name}}</p>
                                        <a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                        <button type="button" class="btn btn-danger  pull-right" data-container="body" data-toggle="popover" data-html="true" data-placement="left" data-trigger="focus" title="Warning!"
                                        data-content='<p>Are you sure you want to proceed?</p>
                                            <a href="{{url('admin/driver/'.$contract->driver->id.'/file/'.$file->id)}}" class="btn btn-danger">Yes</a>
                                            <span class="btn btn-default">No</span>
                                        </form>
                                    '><i class="entypo-cancel"></i>Delete</button>
                                    </td>
                                @endif
                        @empty
                            <tr>
                                <td>
                                    no files
                                </td>
                            </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Upload Files</h3>
                        <form enctype="multipart/form-data" method="POST" action="{{url('admin/driver/add/files/'.$contract->driver->id)}}"> 
                            {!! csrf_field() !!}
                            <label class="custom-file">
                                  <input type="file" id="file" name="file[]" multiple>
                            </label>
                            <input type="submit" name="submit" class="btn btn-primary" value="upload">
                        </form>
                    </div>
                </div>
                <div class="list-group" style="margin-top:20px;">
                    <a class="list-group-item list-group-item-action active">
                        <center><h4>Car Details</h4></center>
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
                                            <td>{{$contract->car->id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Registration Number</td>
                                            <td>
                                                <form method="post" class="form form-inline" action="{{url('admin/contract/'.$contract->id.'/car_update')}}">
                                                    {!! csrf_field() !!}
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                    <select class="form-control" name="car_id"> 
                                                        @foreach($cars as $car)
                                                            <option @if($car->id == $contract->car->id) selected @endif value="{{$car->id}}">{{$car->reg_no}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('car_id')) <p class="help-block">{{ $errors->first('car_id') }}</p> @endif
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="submit" class="btn btn-success btn-sm" value="save">
                                                    </div>
                                                </div>
                                                </form>
                                            </td>    
                                        </tr>
                                        <tr>
                                            <td>Rate</td>
                                            <td>{{$contract->car->price}}</td>
                                        </tr>
                                        <tr>
                                            <td>Make</td>
                                            <td>{{$contract->car->make}}</td>
                                        </tr>
                                        <tr>
                                            <td>Available Since</td>
                                            <td>{{$contract->car->available_since}}</td>
                                        </tr>
                                        <tr>
                                            <td>Comments</td>
                                            <td>{{$contract->car->comments}}</td>
                                        </tr>
                                        <tr>
                                            <td>Custom Id</td>
                                            <td>{{$contract->car->custom_id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Model</td>
                                            <td>{{$contract->car->model}}</td>
                                        </tr>
                                        <tr>
                                            <td>Year</td>
                                            <td>{{$contract->car->year}}</td>
                                        </tr>
                                        <tr>
                                            <td>color</td>
                                            <td>{{$contract->car->color}}</td>
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
                                            <td>Transmission</td>
                                            <td>{{$contract->car->transmission}}</td>
                                        </tr>
                                        <tr>
                                            <td>Fuel Type</td>
                                            <td>{{$contract->car->fuel_type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Chasis Number</td>
                                            <td>{{$contract->car->chasis_num}}</td>
                                        </tr>
                                        <tr>
                                            <td>Engine Size</td>
                                            <td>{{$contract->car->engine_size}}</td>
                                        </tr>
                                        <tr>
                                            <td>First Registration Date</td>
                                            <td>{{$contract->car->first_reg_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Keeper</td>
                                            <td>{{$contract->car->keeper}}</td>
                                        </tr>
                                        <tr>
                                            <td>pco_license</td>
                                            <td>{{$contract->car->pco_licence}}</td>
                                        </tr>
                                        <tr>
                                            <td>PCO Expires at</td>
                                            <td>{{$contract->car->pco_expires_at}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
