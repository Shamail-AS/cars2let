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
                            <th colspan="2"><center><h3> Ticket {{$ticket->id}}</h3></center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Car</td>
                            <td>{{$ticket->car->reg_no}}</td>
                        </tr>
                        <tr>
                            <td>Driver</td>
                            <td>{{$ticket->driver->name}}</td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Upload Files</h3>
                <form enctype="multipart/form-data" method="POST" action="{{url('api/admin/cars/'.$ticket->car->id.'/tickets/'.$ticket->id.'/attachment')}}"> 
                    {!! csrf_field() !!}
                    <label class="custom-file">
                          <input type="file" id="file" name="file" multiple>
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