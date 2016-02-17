@extends('app')

@section('content')
    <h1>Register Drivers</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form" method="POST" action="{{url('/admin/driver/store')}}">
                    {!! csrf_field() !!}
                    <div class="form-group {{$error->has('name') ? 'has-error':''}}">
                        <label class="form-control">Name</label>
                        <input class="form-control" type="text" name="name" value="{{old('name')}}">
                        @if($error->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{$error->has('email') ? 'has-error':''}}">
                        <label class="form-control">Email</label>
                        <input class="form-control" type="text" name="email" value="{{old('email')}}">
                        @if($error->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{$error->has('license_no') ? 'has-error':''}}">
                        <label class="form-control">License Number</label>
                        <input class="form-control" type="text" name="license_no" value="{{old('license_no')}}">
                        @if($error->has('license_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('license_no') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
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