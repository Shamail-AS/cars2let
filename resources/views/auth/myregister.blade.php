@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/myregister') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--<div class="form-group{{ $errors->has('pass') ? ' has-error' : '' }}">--}}
                            {{--<label class="col-md-4 control-label">Password</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input type="password" class="form-control" name="pass" value="{{ old('pass') }}">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        {{--<div class="form-group{{ $errors->has('licence_num') ? ' has-error' : '' }}">--}}
                            {{--<label class="col-md-4 control-label">Licence Number</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input type="text" class="form-control" name="licence_num" value="{{ old('licence_num') }}">--}}

                                {{--@if (Session::has('detail_mismatch'))--}}
                                {{--<span class="help-block">--}}
                                        {{--<strong>{{ Session::get('detail_mismatch') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Send verification email
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
