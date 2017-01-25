@extends('layouts.app')

@section("styles")
    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/investor_car_details.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="card-container centered">
        <div class="card">
            <div class="card-header ongoing">
                <h1>Register a new car</h1>
            </div>
            <div class="card-body">
                <form class="form" method="POST" action="{{url('/investor/assets/car/store')}}">
                    {!! csrf_field() !!}
                    {{--<div class="form-group {{$error->has('reg_no') ? 'has-error':''}}">--}}
                    <div class="form-group">
                        <label>Registration No</label>
                        <input class="form-control" type="text" name="reg_no" value="{{old('reg_no')}}">
                        {{--@if($error->has('reg_no'))--}}
                        {{--<span class="help-block">--}}
                        {{--<strong>{{ $errors->first('reg_no') }}</strong>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                    </div>
                    <div class="form-group">
                        {{--                    <div class="form-group {{$error->has('make') ? 'has-error':''}}">--}}
                        <label>Make</label>
                        <input class="form-control" type="text" name="make" value="{{old('make')}}">
                        {{--@if($error->has('make'))--}}
                        {{--<span class="help-block">--}}
                        {{--<strong>{{ $errors->first('make') }}</strong>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                    </div>
                    <div class="form-group ">
                        <label>Available Since</label>
                        <input class="form-control dp" type="date" name="available_since"
                               value="{{old('available_since')}}">
                    </div>
                    <div class="form-group">
                        {{--<div class="form-group {{$error->has('comments') ? 'has-error':''}}">--}}
                        <label>Comments</label>
                        <input class="form-control" type="text" name="comments"
                               value="{{old('comments')}}">
                        {{--@if($error->has('comments'))--}}
                        {{--<span class="help-block">--}}
                        {{--<strong>{{ $errors->first('comments') }}</strong>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                    </div>
                    <div class="form-group">
                        <div>
                            {{--<button type="button" class="btn btn-warning" onclick="window.history.back()">--}}
                            {{--<i class="fa fa-btn fa-times"></i>Cancel--}}
                            {{--</button>--}}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-car"></i>Register
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection