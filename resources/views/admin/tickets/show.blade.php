@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/assets/tickets.css')}}" rel="stylesheet">
@endsection

@section('content')
    <h1> Ticket {{$ticket->id}}</h1>
    <div id="details">
        <div class="form-group">
            <label>Car</label>
            <h4>{{$ticket->car->reg_no}}</h4>
        </div>
        <div class="form-group">
            <label>Driver</label>
            <h4>{{$ticket->driver->name}}</h4>
        </div>
    </div>

    <div id="files">
        <div id="file-list">

        </div>
        <div id="file-add">
            <form method="POST" action="{{url('admin/tickets/'.$ticket->id.'/attach')}}">
                {!! csrf_field() !!}
                <input class="form-control" type="file" name="file">
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

    </div>
@endsection