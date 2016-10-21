@extends('layouts.app')

@section('styles')
    <style>
        .flex-center {
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
            font-weight: 400;
            text-shadow: 0px 0px 4px rgba(255, 250, 250, 0.56);

        }

        .flex-center a {
            text-decoration-color: rgba(214, 74, 72, 0.00);
            color: rgba(18, 122, 47, 0.68);
            text-shadow: 0 0px 6px rgba(106, 106, 106, 0.54);
        }

        .flex-center img {
            margin-bottom: 20px;
        }

        .wrapper {
            text-align: center;
        }

        .navbar-c2l {
            background-color: rgba(46, 168, 66, 0.32);
        !important;
        }

        body {
            background-image: url("/img/background/simple1.jpg");
            background-size: 100% 100%; /* <------ */
            background-repeat: no-repeat;
            background-position: center center;
        }
    </style>
@endsection

@section('content')
    <div class="flex-center">
        <div class="flex-center stretch">
            <img src="{{asset(url("/img/background/logo.png"))}}"/>

            <div class="wrapper">
                <p>Welcome to the Cars2Let Investor Portal.</p>
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
    </div>
@endsection
