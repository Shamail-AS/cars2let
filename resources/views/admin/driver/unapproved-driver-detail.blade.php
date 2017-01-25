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
                <form method="post" action="{{ url('admin/driver/update/'.$contract->driver->id) }}">
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
                                                   <input type='text' id='licence_no' name="licence_no" class="form-control" value="{{$contract->driver->licence_no}}"/>
                                                   @if ($errors->has('licence_no')) <p class="help-block">{{ $errors->first('licence_no') }}</p> @endif
                                               </div>
                                              {{$contract->driver->pco_license_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{$contract->driver->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{$contract->driver->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date Of Birth</td>
                                            <td>{{date("M d, Y",strtotime($contract->driver->dob))}}</td>
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
                                            <td>{{$contract->driver->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Passpport</td>
                                            <td>{{$contract->driver->passport}}</td>
                                        </tr>
                                        <tr>
                                            <td>Passport Expiry At</td>
                                            <td>{{date("M d, Y",strtotime($contract->driver->pass_exp_at))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Nationality</td>
                                            <td>{{$contract->driver->nationality}}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Person</td>
                                            <td>{{$contract->driver->emerg_person}}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Number</td>
                                            <td>{{$contract->driver->emerg_num}}</td>
                                        </tr>
                                        <tr>
                                            <td>Years living in the Uk</td>
                                            <td>{{$contract->driver->years_in_uk}}</td>
                                        </tr>
                                        <tr>
                                            <td>PCO Expires on </td>
                                            <td>{{ date("M d, Y",strtotime($contract->driver->pco_expires_at)) }}</td>
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
                                            <td>{{  date("M d, Y",strtotime($contract->driver->licence_exp_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>{{$contract->driver->type}}</td>
                                        </tr>
                                        <tr>
                                            <td>National Insurance Number</td>
                                            <td>{{$contract->driver->nino}}</td>
                                        </tr>
                                        <tr>
                                            <td>Right to Work</td>
                                            <td>{{$contract->driver->right_to_work}}</td>
                                        </tr>
                                        <tr>
                                            <td>Driving Since</td>
                                            <td>{{$contract->driver->driving_since}}</td>
                                        </tr>
                                        <tr>
                                            <td>Penelty Points</td>
                                            <td>{{$contract->driver->penalty_points}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group">
                    <a class="list-group-item list-group-item-action active">
                        <center><h4>Driver Files</h4></center>
                    </a>

                </div>
                <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tbody>
                        @forelse($contract->driver->files as $file)
                            <tr>
                                @if($file->type == 'image')
                                <td>
                                    <img style="display: inline-block;" class="img-responsive" src="{{$file->full_url}}" width="100">
                                    <a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                    <a href="{{url('admin/driver/'.$contract->driver->id.'/file/'.$file->id)}}" class="btn btn-danger pull-right">Delete</a>

                                </td>
                            </tr>
                                @else
                                  <tr>
                                    <td>
                                        <p style="display: inline-block;">{{$file->name}}</p>
                                        <a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                        <a href="{{url('admin/driver/'.$contract->driver->id.'/file/'.$file->id)}}" class="btn btn-danger pull-right">Delete</a>

                                    </td>
                                  </tr>
                                @endif
                            </tr>
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
                <div class="list-group">
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
                                            <td>{{$contract->car->reg_no}}</td>
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
