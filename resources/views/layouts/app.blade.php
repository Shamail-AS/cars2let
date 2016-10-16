<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cars2Let Monitor Station</title>

    <!-- Fonts -->
    <link href="{{asset('css/fa/css/font-awesome.min.css')}}" rel='stylesheet' type='text/css'>
    <link href="{{asset('css/lato-google.css')}}" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />--}}
    <link href="{{asset('css/ng-select.css')}}" rel="stylesheet" />
    @yield('styles')

    <!-- JavaScripts -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootbox.min.js')}}"></script>
    <script src="{{asset('js/angular/lodash.js')}}"></script>
    <script src="{{asset('js/angular/moment-with-locales.min.js')}}"></script>
    {{--<script src="{{asset('js/select2.min.js')}}"></script>--}}
    <script src="{{asset('js/angular/angular.js')}}"></script>
    <script src="{{asset('js/angular/angular-moment.min.js')}}"></script>
    <script src="{{asset('js/angular/angular-sanitize.js')}}"></script>
    <script src="{{asset('js/angular/ng-select.js')}}"></script>

    @yield('scripts')



</head>
<body id="app-layout">
    <nav class="navbar navbar-c2l navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand navbar-brand-c2l " href="{{ url('/') }}">
                    Cars2Let Monitor Station
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <!--<li><a href="{{ url('/home') }}">Home</a></li>-->
					@if (!Auth::guest())
                        <li><a href="{{ url('investor') }}">Dashboard</a></li>
                        @if(Auth::user()->isInvestor)
						<li><a href="{{ url('investor/cars') }}">Asset Reports</a></li>
                        @endif
					@endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())

                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/myregister') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{Auth::user()->email}} <span class="caret"></span>
                                {{--{{Auth::user()->isAdmin ? Auth::user()->email : Auth::user()->investor->name }} <span class="caret"></span>--}}
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                <li><a href="{{ url('/help') }}"><i class="fa fa-question-circle fa-btn"></i>Help</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')


</body>
<script>

    $('.dp').datepicker({
        dateFormat: "dd-mm-yy"
    });
</script>
</html>
