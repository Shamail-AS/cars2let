@extends('app')

@section('styles')
    <style>
        .code-container {

            border: 1px solid #d5d5d5;
            border-radius: 35px;
            background-color: #ffffff;

            margin: 42px 12px 40px 12px;

            min-width: 256px;
            min-height: 256px;
            width: auto;
            height: auto;
        }

        .code-main {
            border-top-left-radius: 35px;
            border-top-right-radius: 35px;
            padding: 50px;
            text-align: center;

        }

        .code-sub {
            padding: 10px;
            text-align: center;
            background-color: rgb(53, 189, 83);
            align-items: center;
        }

        .code-sub p {
            font-weight: lighter;
            color: #ffffff;
            font-size: 1em;
            margin: 2px;
        }

        .code-main p {
            font-weight: bolder;
            color: #7e7e7e;
            font-size: 1.2em;
            margin: 2px;
        }

        .footer {
            text-align: center;
        }

        .footer p {
            font-size: small;
            color: gray;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="code-container">
            <div class="code-main">
                <p>Please click <a href="{{url('/verify/token/'.$code)}}">here</a> to complete your registration</p>
            </div>
            <div class="code-sub">
                You will be able to choose your account password when you click the link.
            </div>
        </div>
        <div class="footer">
            <p>This service is brought to you by Cars2Let Investor Portal.
                If you are not the intended recipient please ignore this email</p>
        </div>
    </div>


@endsection