@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Enabling iframes</h1>

                <p>Iframes allow us to provide you a richer experience by integrating content from multiple sources.
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

                <p><strong>The warning says unsecure parts because not every iframe is safe. We only use 1 iframe to
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

                <p><strong>The name says unsafe because not every iframe is safe. We only use 1 iframe to provide
                        tracking services, which is safe</strong></p>
                <img src="{{asset('/img/support/chrome/2.png')}}">

                <p>This should automatically reload the page and enable the iframe on your Dashboard</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h1>Internet Explorer 9</h1>

                <h3>It is recommended NOT to use this browser to access the portal due to compatibility issues</h3>
                <h4>Use Chrome or Firefox instead</h4>
                <hr>
                <p>Locate this icon in your address bar. Click the icon and click Internet options</p>
                <img src="{{asset('/img/support/IE9/1.png')}}"/>

                <p>Click the security tab, then Trusted Sites, then Add</p>
                <img src="{{asset('/img/support/IE9/2.png')}}"/>

                <p>Add the portal's web address to trusted sites. Make sure it starts with https, (note the 's'). Then
                    click Done.</p>
                <img src="{{asset('/img/support/IE9/3.png')}}"/>

                <p>This should automatically reload the page. Look for this at the bottom of your page.</p>
                <img src="{{asset('/img/support/IE9/4.png')}}"/>

                <p><strong>The warning says unsafe because not every iframe is safe. We only use 1 iframe to provide
                        tracking services, which is safe</strong></p>

                <p>Click the button. This will refresh the page and enable the iframe on your Dashboard</p>
            </div>
        </div>

    </div>

@endsection