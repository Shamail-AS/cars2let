@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Verify Account</div>
                    <div class="panel-body">
                        <div class="jumbotron">
                            <div class="heading">
                                <h2>We have sent you the authentication link.
                                </h2>

                                <p> Please click on the link as instructed in the email.
                                    If you don't receive it within 10 minutes, try resending the code
                                </p>
                            </div>
                            <a href="{{url('code/destination')}}" class="btn btn-info">
                                <i class="fa fa-btn fa-refresh"></i>Resend Code
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection