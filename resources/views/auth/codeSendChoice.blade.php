@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verify Account</div>
                    <div class="panel-body">

                        <h1>Chose where to send activation code</h1>
                        <form  role="form" method="POST" action="{{url('/code/send')}}">
                            {!! csrf_field() !!}

                            <div class="checkbox form-group">
                                <label><input checked="checked" type="radio" name="sendTo" value="email">Send code to
                                    email</label>
                            </div>

                            {{--<div class="checkbox">--}}
                            {{--<label><input  type="radio" name="sendTo" value="phone">Send code to phone</label>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Send Code selected places</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection