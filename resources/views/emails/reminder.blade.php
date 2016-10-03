@extends('app')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="flex-container">
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



@endsection
