@extends('app')

@section('content')
    <h1>Register Admins</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form" method="POST" action="{{url("/admin/store")}}">
                    {!! csrf_field() !!}

                    <div class="form-group {{$errors->has('email') ? 'has-error':''}}">
                        <label class="form-control">Email</label>
                        <input class="form-control" type="text" name="email" value="{{old('email')}}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has('password') ? ' has-error':''}}">
                        <label class="form-control">Password</label>
                        <input class="form-control" type="text" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{$error->has('password_confirmation') ? 'has-error':''}}">
                        <label class="form-control">Confirm Password</label>
                        <input class="form-control" type="text" name="password_confirmation">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
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