@extends('app')

@section('content')
    <h1>Register New Car</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form" method="POST" action="{{url('/admin/car/store')}}">
                    {!! csrf_field() !!}
                    <div class="form-group {{$error->has('reg_no') ? 'has-error':''}}">
                        <label class="form-control">Registration No</label>
                        <input class="form-control" type="text" name="reg_no" value="{{old('reg_no')}}">
                        @if($error->has('reg_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('reg_no') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{$error->has('make') ? 'has-error':''}}">
                        <label class="form-control">Make</label>
                        <input class="form-control" type="text" name="make" value="{{old('make')}}">
                        @if($error->has('make'))
                            <span class="help-block">
                                <strong>{{ $errors->first('make') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{$error->has('comments') ? 'has-error':''}}">
                        <label class="form-control">Comments</label>
                        <input class="form-control" type="text" name="comments" value="{{old('comments')}}">
                        @if($error->has('comments'))
                            <span class="help-block">
                                <strong>{{ $errors->first('comments') }}</strong>
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