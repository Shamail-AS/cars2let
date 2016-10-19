@extends('app')

@section('styles')
    <style>
        .code-container {

            border: 1px solid #d5d5d5;
            border-radius: 35px;
            background-color: #ffffff;
            box-shadow: 0px 0.5px 8px rgba(112, 112, 112, 0.47);
            margin: 42px 12px 40px 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: stretch;
            min-width: 256px;
            min-height: 256px;
            width: auto;
            height: auto;
        }

        .code-main {
            border-top-left-radius: 35px;
            border-top-right-radius: 35px;
            flex: 2 0 auto;
            background-color: rgb(53, 189, 83);
            padding: 50px;
            display: flex;
            justify-content: space-around;
            align-items: stretch;

        }

        .code-sub {
            padding: 10px;
            flex: 1 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .code-sub p {
            font-weight: lighter;
            color: #7e7e7e;
            font-size: 1.2em;
            margin: 2px;
        }

        .code-main p {
            font-weight: bolder;
            color: #ffffff;
            font-size: 6em;
            margin: 2px;
        }

        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer p {
            font-size: x-small;
            color: gray;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="code-container">
            <div class="code-main">
                <p>{{$code}}</p>
            </div>
            <div class="code-sub">
                <p>Please use this code to complete your registration. It will expire in 30 minutes</p>
                @if($admin)
                    <p>Please use 'sample' without the quotes as you first password. You can change it after entering
                        the code</p>

                @endif
            </div>
        </div>
        <div class="footer">
            <p>This service is brought to you by Cars2Let Investor Portal.
                If you are not the intended recipient please ignore this email</p>
        </div>
    </div>


@endsection