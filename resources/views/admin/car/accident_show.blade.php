@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th colspan="2"><center><h3>Accident Details</h3></center>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Car</td>
                            <td>{{$accident->car->reg_no}}</td>
                        </tr>
                        <tr>
                            <td>Driver</td>
                            <td>{{$accident->driver->name}}</td>
                        </tr>
                        <tr>
                            <td>Incident Time</td>
                            <td>{{$accident->incident_at}}</td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td>{{$accident->location}}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{strtoupper($accident->status)}}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>{{strtoupper($accident->type)}}</td>
                        </tr>
                        <tr>
                            <td>Weather Condition</td>
                            <td>{{$accident->weather_cond}}</td>
                        </tr>
                        <tr>
                            <td>Road Condition</td>
                            <td>{{$accident->road_cond}}</td>
                        </tr>
                        <tr>
                            <td>Police Details</td>
                            <td>{{$accident->police_details}}</td>
                        </tr>
                        <tr>
                            <td>Comments</td>
                            <td>{{($accident->comments)}}</td>
                        </tr>
                        <tr>
                            <td>3rd party Car</td>
                            <td>{{($accident->x_car_reg)}}</td>
                        </tr>
                        <tr>
                            <td>3rd party Car Details</td>
                            <td>{{($accident->x_car_details)}}</td>
                        </tr>
                        <tr>
                            <td>3rd party Driver Name</td>
                            <td>{{($accident->x_driver_name)}}</td>
                        </tr>
                        <tr>
                            <td>3rd party Driver Licence</td>
                            <td>{{($accident->x_driver_licence)}}</td>
                        </tr>
                        <tr>
                            <td>3rd party Insured Name</td>
                            <td>{{($accident->x_insured_name)}}</td>
                        </tr>
                        <tr>
                            <td>3rd party Insured Company</td>
                            <td>{{($accident->x_insured_comp)}}</td>
                        </tr>
                        <tr>
                            <td>3rd party Insured Policy</td>
                            <td>{{($accident->x_insured_policy)}}</td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th><h3 style="display: inline-block;">Uploaded Files</h3>
                            <a href="{{url('api/admin/cars/'.$accident->car->id.'/accidents/'.$accident->id.'/pdf')}}" class="btn btn-success pull-right"> Download the Files</a>  
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accident->files as $file)
                            <tr>
                                @if($file->type == 'image')
                                <td>
                                    <img class="img-responsive" src="{{$file->full_url}}" width="100"><a href="{{$file->full_url}}" class="btn btn-primary" download>Download</a>
                                </td>
                                @else
                                    <td>
                                        <p>{{$file->name}}</p><a href="{{$file->full_url}}" class="btn btn-primary" download>Download</a>
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
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Upload Files</h3>
                <form enctype="multipart/form-data" method="POST" action="{{url('api/admin/cars/'.$accident->car->id.'/accidents/'.$accident->id.'/attachment')}}"> 
                    {!! csrf_field() !!}
                    <label class="custom-file">
                          <input type="file" id="file" name="file[]" multiple>
                    </label>
                    <input type="submit" name="submit" class="btn btn-primary" value="upload">
                </form>
            </div>
        </div>
    </div>
{{--     <div id="files">
        <div id="file-list">

        </div>
        <div id="file-add">
            <form method="POST" action="{{url('admin/tickets/'.$ticket->id.'/attach')}}">
                {!! csrf_field() !!}
                <input class="form-control" type="file" name="file">
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

    </div> --}}
@endsection