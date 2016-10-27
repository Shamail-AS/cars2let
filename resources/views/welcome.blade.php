@extends('layouts.app')

@section('styles')
    <style>
        .flex-center {
            padding-top: 51px;
            display: flex;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .flex-center.stretch {
            flex: 1 0 auto;
        }

        .flex-center p {
            color: rgba(255, 255, 255, 0.88);
            font-size: 4em;
            font-weight: 100;
            text-shadow: 0px 0px 20px rgba(255, 250, 250, 0.26);


        }

        .flex-center a {
            text-decoration-color: rgba(214, 74, 72, 0.00);
            color: rgba(14, 178, 0, 0.82);
            text-shadow: 0 0px 20px rgba(106, 106, 106, 0.14);
            font-weight: 300;

        }

        .navbar-c2l .navbar-right a {
            color: rgba(27, 27, 27, 0.72);
        !important;
        }

        .flex-center img {
            margin-bottom: 20px;
        }

        .wrapper {
            text-align: center;
        }

        .navbar-c2l {
            background-color: rgba(250, 250, 250, 0.10);
            border-bottom: solid 1px rgba(254, 255, 253, 0.1);
        !important;
        }

        body {
            background-image: url("/img/background/simple5.jpg");
            background-size: cover; /* <------ */
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
@endsection

@section('content')
    <div class="flex-center stretch">
        <img src="{{asset(url("/img/background/logo.png"))}}"/>

        <div class="wrapper">
            <p>Welcome to the Cars2Let Members Area.</p>
            @if(Auth::guest())
                <p>Please <a href="{{ url('/login') }}">Login</a> or <a href="{{ url('/myregister') }}">Register</a>
                    to continue</p>
            @endif

            @if(!Auth::guest() && Auth::user()->isInvestor)
                <p>Check out your <a href="{{ url('investor') }}">Dashboard</a></p>
            @endif
            <br>
            @if(!Auth::guest() && Auth::user()->isAdmin)
                <p>Check out your <a href="{{ url('investor') }}">Dashboard</a></p>
            @endif
        </div>

    </div>
@endsection
