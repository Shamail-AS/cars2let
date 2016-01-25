@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verify Account</div>
                    <div class="panel-body">

                        <form class="form-vertical" role="form" method="POST" action="{{ url('/code/verify') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">

                                <h1>Please enter the code that has been sent to you</h1>

                                <label>Code</label>
                                <input type="text" class="form-control" name="code">

                                @if (Session::has('code_mismatch'))
                                    <span class="help-block">
                                        <strong>{{ Session::get('code_mismatch') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Verify Code
                                    </button>
                                    <a href="{{url('code/destination')}}" class="btn btn-info">
                                        <i class="fa fa-btn fa-refresh"></i>Resend Code
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection