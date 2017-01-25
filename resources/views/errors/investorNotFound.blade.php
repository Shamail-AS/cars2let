<!DOCTYPE html>
<html>
<head>
    <title>Investor not found.</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #28975e;
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
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 36px;
            margin-bottom: 40px;
        }
        a{
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">{{$message}}</div>
        <div class="subtitle">Please visit <a href="http://www.google.com">this page</a> to start your journey if you haven't already</div>
    </div>
</div>
</body>
</html>
