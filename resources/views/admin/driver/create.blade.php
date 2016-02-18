@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Register a new Driver
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form" method="POST" action="{{url('/admin/driver/store')}}">
                                    {!! csrf_field() !!}
                                    <div class="form-group ">
                                        {{--<div class="form-group {{$error->has('name') ? 'has-error':''}}">--}}
                                        <label >Name</label>
                                        <input class="form-control" type="text" name="name" value="{{old('name')}}">
                                        {{--@if($error->has('name'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                    </div>
                                    <div class="form-group ">
                                        {{--<div class="form-group {{$error->has('email') ? 'has-error':''}}">--}}
                                        <label >Email</label>
                                        <input class="form-control" type="text" name="email" value="{{old('email')}}">
                                        {{--@if($error->has('email'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                    </div>
                                    <div class="form-group ">
                                        {{--<div class="form-group {{$error->has('license_no') ? 'has-error':''}}">--}}
                                        <label>License Number</label>
                                        <input class="form-control" type="text" name="license_no" value="{{old('license_no')}}">
                                        {{--@if($error->has('license_no'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('license_no') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                    </div>
                                    <div class="form-group ">
                                        {{--<div class="form-group {{$error->has('license_no') ? 'has-error':''}}">--}}
                                        <label>DOB</label>
                                        <input class="form-control" type="date" name="dob" value="{{old('dob')}}">
                                        {{--@if($error->has('license_no'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('license_no') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                    </div>
                                    <div class="form-group ">
                                        {{--<div class="form-group {{$error->has('license_no') ? 'has-error':''}}">--}}
                                        <label>Phone Number</label>
                                        <input class="form-control" type="text" name="phone" value="{{old('phone')}}">
                                        {{--@if($error->has('license_no'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('license_no') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                    </div>
                                    <div class="form-group">
                                        <div >
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-user"></i>Register
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection