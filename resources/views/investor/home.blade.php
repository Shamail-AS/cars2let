@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="flex-container">
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d19846.006685263703!2d-1.7580300999999998!3d51.55446775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1453767116129"
                    width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
            <div class="sidebar sidebar-left">
                <div class="sidebar-item">
                    <img src="http://mimedu.es/wp-content/uploads/2015/03/mercedes-logotipo.jpg">

                    <p class="title">Mercedes</p>

                    <p class="subtitle">London,SW14 7NJ</p>
                </div>
                <div class="sidebar-item">
                    <img src="http://mimedu.es/wp-content/uploads/2015/03/mercedes-logotipo.jpg">

                    <p class="title">Mercedes</p>

                    <p class="subtitle">London,SW14 7NJ</p>
                </div>
                <div class="sidebar-item">
                    <img src="http://mimedu.es/wp-content/uploads/2015/03/mercedes-logotipo.jpg">

                    <p class="title">Mercedes</p>

                    <p class="subtitle">London,SW14 7NJ</p>
                </div>

            </div>
        </div>
        <div class="revenue-container">

            <div class="revenue-summary">

                <div class="summary-section-row">
                    <div class="summary-section">
                        <div class="heading">
                            <h3>Revenue Overview</h3>
                        </div>
                        <div class="data-summary">
                            <table class="table table-bordered">
                                <tr>
                                    <th></th>
                                    <th>Since Joining (£)</th>
                                    <th>For current accounting period (£)</th>
                                </tr>
                                <tr>
                                    <td>Investor Revenue </td>
                                    <td>{{$investor->revenue}}</td>
                                    <td>{{$investor->revenueForCurrentPeriod}}</td>
                                </tr>
                                <tr>
                                    <td>Paid to investor </td>
                                    <td>{{$investor->paid}}</td>
                                    <td>{{$investor->paidForCurrentPeriod}}</td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>{{$investor->balance}}</td>
                                    <td>{{$investor->balanceForCurrentPeriod}}</td>
                                </tr>
                            </table>
                            <div class="heading">
                                <h4>*Subject to adjustments for VAT and other expenses</h4>
                            </div>
                        </div>
                    </div>
                    <div class="summary-section">

                        <div class="heading">
                            <a href="{{url('/investor/cars')}}"><h3><b>{{$investor->cars()->count()}}</b> Total Cars</h3></a>

                            <a href="{{url('/investor/contracts')}}"><h3><b>{{$investor->contracts()->count()}}</b> Total Contracts</h3></a>

                            <a href="{{url('/investor/drivers')}}"><h3><b>{{$investor->drivers->count()}}</b> Total Drivers</h3></a>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @if(!Auth::user()->isActive))
    <div class="floater">
        <p>Your account is inactive. Please use the activation link sent to you to activate or enter code now</p>
        <button id="btn-code-enter" class="btn btn-sm btn-primary">Enter code</button>
        <button id="btn-code-resend" class="btn btn-sm btn-danger">Resend code</button>


    </div>
    @endif
    <script>
        $(document).ready(function () {
            $('.group-row').click(function () {
                $(this).find("[class^=data-]").toggleClass('collapsed');
            });
            $('.heading').click(function () {
                $(this).next('.data').toggleClass('collapsed');
            });
            $("#btn-code-enter").click(function () {
                bootbox.prompt('Please enter the code', function (result) {
                    if (result === null) {

                    }
                    else {
                        $.get('/api/code/' + result + '/verify', function (response) {
                            if (response.indexOf('Sorry') > -1) {
                                bootbox.alert(response);
                            }
                            else {
                                bootbox.alert('Your account has been activated! ');
                                $('.floater').addClass('collapsed');
                            }

                        });
                    }
                });
            })
        });
    </script>

@endsection
