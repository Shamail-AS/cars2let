<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cars2Let Members Area</title>

    <!-- Fonts -->
    <link href="{{asset('css/fa/css/font-awesome.min.css')}}" rel='stylesheet' type='text/css'>
    <link href="{{asset('css/lato-google.css')}}" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/ng-select.css')}}" rel="stylesheet" />
    <link href="{{asset('css/dropzone.css')}}" rel="stylesheet"/>

    @yield('styles')

    <!-- JavaScripts -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootbox.min.js')}}"></script>
    <script src="{{asset('js/lean-modal.min.js')}}"></script>
    <script src="{{asset('js/angular/lodash.js')}}"></script>
    <script src="{{asset('js/angular/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('js/dropzone.js')}}"></script>

    <script src="{{asset('js/angular/angular.js')}}"></script>
    <script src="{{asset('js/angular/angular-animate.js')}}"></script>
    <script src="{{asset('js/angular/angular-moment.min.js')}}"></script>
    <script src="{{asset('js/angular/angular-sanitize.js')}}"></script>
    <script src="{{asset('js/angular/angular-route.js')}}"></script>
    <script src="{{asset('js/angular/angular-modal-service.min.js')}}"></script>
    <script src="{{asset('js/angular/ng-select.js')}}"></script>
    <script src="{{asset('js/angular/ui-bootstrap-tpls-2.2.0.min.js')}}"></script>
    <script src="{{asset('js/angular/ng-dropzone.js')}}"></script>
    <script src="{{asset('js/angular/angular-file-upload.js')}}"></script>


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
                    <strong>Cars2Let Members Area</strong>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                    @if (!Auth::guest() && Auth::user()->status == 'active')
                        @if(Auth::user()->isAdmin)
                            <li class="active"><a href="{{ url('admin') }}">Dashboard</a></li>

                        @elseif(Auth::user()->isInvestor)
                            <li><a href="{{ url('investor') }}">Dashboard</a></li>
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

                            <ul class="dropdown-menu padded" role="menu">
                                @if(Auth::user()->isInvestor)
                                    <li><a href="{{ url('/investor/show/'.Auth::user()->investor->id) }}">
                                            <i class="fa fa-user fa-btn"></i>Profile
                                        </a>
                                    </li>
                                @endif
                                <li><a href="{{ url('/help') }}"><i
                                                class="fa fa-question-circle fa-btn"></i>Help</a></li>
                                <li><a href="{{ url('reset/password') }}"><i
                                                class="fa fa-cog fa-btn"></i>Reset Password</a></li>

                                <li><a href="{{ url('/logout') }}"><i
                                                class="fa fa-btn fa-sign-out"></i>Logout</a></li>
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
        //TODO THIS WILL CAUSE INCONSISTENT BEHAVIOUR WHEN EDITING INVESTOR DETAILS IN INVESTOR SECTION
        dateFormat: "dd-mm-yy"
    });
</script>
</html>
