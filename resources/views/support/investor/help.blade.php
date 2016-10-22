@extends('layouts.app')

@section('styles')
    <style>

        .top-right {
            top: 0;
            right: 0;
            margin: 20px;

            min-width: 20%;
        }

        .fixed {
            position: fixed;
        }

        .placeholder {
            text-align: center;
            color: gray;
            font-size: large;
            font-weight: 300;
            padding: 20px;
            background-color: rgba(191, 191, 191, 0.3);
            flex: 1 0 auto;
            margin-top: 50px;

        }

        .placeholder p {
            max-width: 100%;
            text-wrap: normal;
            text-align: center;

        }

        .main-body {
            padding-right: 30%;
        }

        i {
            margin-right: 5px;
        }
    </style>
@endsection


@section('content')

    <div class="container">
        <div>
            <div class="main-body">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Enabling iframes</h1>

                        <p>Iframes allow us to provide you a richer experience by integrating content from multiple
                            sources.
                            Most modern browsers support this technology but have it disabled by default. Following are
                            instructions for how to allow iframes within our trusted Cars2Let investor portal.
                        </p>
                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-md-12">
                        <h1>Firefox</h1>
                        <hr>
                        <p>Locate this icon in your address bar</p>
                        <img src="{{asset('/img/support/firefox/1.png')}}"/>

                        <p>Click the icon and click the right chevron</p>
                        <img src="{{asset('/img/support/firefox/2.png')}}">

                        <p>Click 'Disable protection for now'</p>

                        <p><strong>The warning says unsecure parts because not every iframe is safe. We only use 1
                                iframe to
                                provide tracking services, which is safe</strong></p>
                        <img src="{{asset('/img/support/firefox/3.png')}}">

                        <p>This should automatically reload the page and enable the iframe on your Dashboard</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h1>Chrome</h1>
                        <hr>
                        <p>Locate this icon in your address bar</p>
                        <img src="{{asset('/img/support/chrome/1.png')}}"/>

                        <p>Click the icon and click allow unsafe scripts</p>

                        <p><strong>The name says unsafe because not every iframe is safe. We only use 1 iframe to
                                provide
                                tracking services, which is safe</strong></p>
                        <img src="{{asset('/img/support/chrome/2.png')}}">

                        <p>This should automatically reload the page and enable the iframe on your Dashboard</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h1>Internet Explorer 9</h1>

                        <h3>It is recommended NOT to use this browser to access the portal due to compatibility
                            issues</h3>
                        <h4>Use Chrome or Firefox instead</h4>
                        <hr>
                        <p>Locate this icon in your address bar. Click the icon and click Internet options</p>
                        <img src="{{asset('/img/support/IE9/1.png')}}"/>

                        <p>Click the security tab, then Trusted Sites, then Add</p>
                        <img src="{{asset('/img/support/IE9/2.png')}}"/>

                        <p>Add the portal's web address to trusted sites. Make sure it starts with https, (note the
                            's'). Then
                            click Done.</p>
                        <img src="{{asset('/img/support/IE9/3.png')}}"/>

                        <p>This should automatically reload the page. Look for this at the bottom of your page.</p>
                        <img src="{{asset('/img/support/IE9/4.png')}}"/>

                        <p><strong>The warning says unsafe because not every iframe is safe. We only use 1 iframe to
                                provide
                                tracking services, which is safe</strong></p>

                        <p>Click the button. This will refresh the page and enable the iframe on your Dashboard</p>
                    </div>
                </div>

            </div>
        </div>
        <div>
            <div class="top-right fixed">
                <div class="placeholder">
                    <p>Contact an Admin</p>

                    <form id="email" method="POST" action="{{url('/investor/support/create')}}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Message</label>
                        <textarea
                                form="email"
                                class="form-control"
                                wrap="soft"
                                name="message"
                                rows="5"
                                placeholder="Write your message here"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa fa-envelope fa-fw"></i> Submit
                        </button>
                        <div class="g-recaptcha" data-sitekey="6Ld39AkUAAAAAGYjkCoGBhwtofGD10eiLHGEvDah"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection