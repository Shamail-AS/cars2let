<!DOCTYPE html>
<html>
<head>
    <title>Investor not found.</title>

    <link href="{{asset('css/lato-google.css')}}" rel='stylesheet' type='text/css'>
    <link href="{{asset('css/fa/css/font-awesome.min.css')}}" rel='stylesheet' type='text/css'>

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #d84f4a;
            color: white;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .title {
            font-size: 72px;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 36px;
            margin-bottom: 40px;
        }

        a {
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        i {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Your account has been disabled</div>
        <div class="subtitle"><a href="{{url('/help')}}">Contact an admin</a> to request an admin to enable your account
        </div>
        <div class="title">
            <i class="fa fa-chevron-circle-left fa-2x" onclick="window.history.back()"></i>
        </div>
    </div>
</div>
</body>
</html>
