@extends('layouts.app')

//NOT USED
@section('content')
    <h1>Edit Admin</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form" method="POST" action="{{url("/admin/edit/".$admin->id)}}">
                    {!! csrf_field() !!}

                    {!! method_field('put')!!}

                    <div class="form-group {{$errors->has('email') ? 'has-error':''}}">
                        <label class="form-control">Email</label>
                        <input class="form-control" type="text" name="email" value="{{$admin->email}}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
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