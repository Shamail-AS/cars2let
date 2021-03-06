@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="flex-container">
        <div class="map-container">

            <div class="wrapper-cover">
                <p onclick="toggleSize()"><i id="spinner" class="fa fa-spinner fa-spin"></i> Track Vehicles Now</p>
                <span><p>GPS Live still loading. Please make sure that iframes are not blocked. <a
                                href="{{url('/help')}}">See how</a></p></span>
            </div>
            <div class="iframe-wrapper">
                <iframe id="tracker" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen
                        src="{{$investor->tracking_url}}"
                        sandbox="allow-forms allow-same-origin allow-pointer-lock allow-scripts allow-top-navigation"></iframe>
            </div>

        </div>
        <div class="resizer">
            <p onclick="toggleSize()">Pause Live Tracking</p>
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
                                    <th>
                                        For current accounting period (£)
                                        <i class="fa fa-question-circle"
                                           data-toggle="tooltip"
                                           title="{{$acc_periods[0]->toFormattedDateString()}} - {{$acc_periods[1]->toFormattedDateString()}}"></i>
                                    </th>
                                    {{--<th>--}}
                                    {{--For next accounting period (£)--}}
                                    {{--<i class="fa fa-question-circle"--}}
                                    {{--data-toggle="tooltip"--}}
                                    {{--title="{{$next_acc_periods[0]->toFormattedDateString()}} - {{$next_acc_periods[1]->toFormattedDateString()}}"></i>--}}
                                    {{--</th>--}}
                                </tr>
                                <tr>
                                    <td>Investor Revenue </td>
                                    <td>{{$investor->revenue}}</td>
                                    <td>{{$investor->revenueForCurrentPeriod}}</td>
                                    {{--<td>{{$investor->revenueForNextPeriod}}</td>--}}
                                </tr>
                                <tr>
                                    <td>Paid to investor </td>
                                    <td>{{$investor->paid}}</td>
                                    <td>{{$investor->paidForCurrentPeriod}}</td>
                                    {{--                                    <td>{{$investor->paidForNextPeriod}}</td>--}}
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>{{$investor->balance}}</td>
                                    <td>{{$investor->balanceForCurrentPeriod}}</td>
                                    {{--                                    <td>{{$investor->balanceForNextPeriod}}</td>--}}
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



@endsection

@section('scripts')
    <script>
        var isFullScreen = false;
        var isLoaded = false;
        function toggleSize() {
            if (!isLoaded) {
                return;
            }
            if (isFullScreen) {

                $('.map-container').height('50%');
                $('.revenue-container').fadeIn();
                $('.wrapper-cover').fadeIn();
                $('.resizer').hide();


            }
            else {
                $('.revenue-container').hide();
                $('.map-container').height('100%');

                $('.wrapper-cover').fadeOut();
                $('.resizer').css('display', 'flex');


            }
            isFullScreen = !isFullScreen;
        }



        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('iframe').load(function () {
                isLoaded = true;
                $('#spinner').fadeOut();
                $('.wrapper-cover span').delay(500).fadeOut();
            });
        });
    </script>
@endsection