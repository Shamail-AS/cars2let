@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

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
                                            <td>{{date("M d, Y",strtotime($contract->start_date))}}</td>
                                        </tr>
                                        <tr>
                                            <td>End Date</td>
                                            <td>{{date("M d, Y",strtotime($contract->end_date))}}</td>
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
                                            <td>{{$contract->driver->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>License No</td>
                                            <td>{{$contract->driver->license_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>License No</td>
                                            <td>{{$contract->driver->license_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>PCO License No</td>
                                            <td>{{$contract->driver->pco_license_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>License No</td>
                                            <td>{{$contract->driver->license_no}}</td>
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
                                            <td>Date Of Birthday</td>
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
                                            <td>Years in Uk</td>
                                            <td>{{$contract->driver->years_in_uk}}</td>
                                        </tr>
                                        <tr>
                                            <td>PCO Expires in </td>
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
                                            <td>Nino</td>
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
                        @forelse($contract->driver->files as $file)
                            <tr>
                                @if($file->type == 'image')
                                <td>
                                    <img style="display: inline-block;"  class="img-responsive" src="{{$file->full_url}}" width="100"><a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                </td>
                                @else
                                    <td>
                                        <p style="display: inline-block;">{{$file->name}}</p><a href="{{$file->full_url}}" class="btn btn-primary pull-right" download="true">Download</a>
                                    </td>
                                @endif
                            </tr> 
                        @empty
                            <tr>
                                <td>
                                    no files
                                </td>
                            </tr>
                        @endforelse
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


