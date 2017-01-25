@extends('layouts.app')

@section("styles")
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Register a new Car
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form" method="POST" action="{{url('/admin/car/store')}}">
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
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-car"></i>Register
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