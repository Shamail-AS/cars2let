@extends('layouts.app')

@section('styles')

    <link href="{{ asset('css/sub_nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/investor_contracts.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('partials.assets_subnav',['contracts'=>'active'])

    <div class="contract-container" ng-app="cars2let" ng-controller="contractController">
        <div class="contract-details-table">
            <div class="search-container">
                <div class="form-group">
                    <label>Search</label>
                    <input class="form-control" placeholder="Car reg number" ng-model="filters.car">
                    <input class="form-control" placeholder="Driver name" ng-model="filters.driver" >
                </div>
                <div class="form-group">
                    <label>Date range filter</label>
                    <input type="text" class="form-control dp" ng-model="filters.date_from" placeholder="From date">
                    <input type="text" class="form-control dp" ng-model="filters.date_to" placeholder="To date">
                </div>
                <label>Status filter</label>

                <ui-select ng-model="filters.selected_status">
                    <ui-select-match allow-clear="true" >
                        <span ng-bind="filters.selected_status.key"></span>
                    </ui-select-match>
                    <ui-select-choices repeat="status in (vm.status_collection | filter: $select.search) track by status.value">
                        <span ng-bind="status.key"></span>
                    </ui-select-choices>
                </ui-select>
            </div>
            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Status</td>
                        <td>Start Date</td>
                        <td>End Date</td>
                        <td>Car#</td>
                        <td>Driver</td>
                        <td>Rent (£)/week</td>
                        <td>Weeks done/total</td>
                        <td>Revenue (£)</td>
                        <td>Paid to Investor (£)</td>

                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="contract in vm.contract_collection
                        | filter : {car_reg:filters.car}
                        | filter : {driver_name:filters.driver}
                        | dateFilter : filters.date_from : filters.date_to
                        | filter : {status : filters.selected_status.value}
                        "
                        ng-class="contract.selected ? 'selected' : ''">


                        <td ng-if="contract.status == 1"><i class="fa fa-circle ongoing"></i></td>
                        <td ng-if="contract.status == 2"><i class="fa fa-circle suspended"></i></td>
                        <td ng-if="contract.status == 3"><i class="fa fa-circle terminated"></i></td>
                        <td ng-if="contract.status == 4"><i class="fa fa-circle complete"></i></td>
                        <td ng-click="getContract(contract.id)">@{{formatDate(contract.start_date) }} </td>
                        <td ng-click="getContract( contract.id)">@{{formatDate(contract.end_date) }}</td>
                        <td ng-click="getContract(contract.id )">@{{contract.car_reg}}</td>
                        <td ng-click="getContract(contract.id )">@{{contract.driver_name}}</td>
                        <td ng-click="getContract(contract.id )">@{{contract.rate}}</td>
                        <td ng-click="getContract( contract.id )">@{{contract.weeksDone}}/@{{contract.weeksTotal}}</td>
                        <td ng-click="getContract( contract.id )">@{{contract.revenue}}</td>
                        <td ng-click="getContract( contract.id )">@{{contract.rent}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="detail-section">

            <div class="fixed-footer-button-container">
                <a href="{{url('/investor/assets/create/contract')}}" class="fixed-footer-button"><i class="fa fa-plus fa-3x"></i></a>
            </div>
            <div class="detail-meta" ng-if="vm.contract.id != undefined">
                <div class="card-container column">
                    <div class="card">
                        <div ng-if="vm.contract.status == 1" class="tag-header ongoing"><p>Ongoing</p></div>
                        <div ng-if="vm.contract.status == 2" class="tag-header suspended"><p>Suspended</p></div>
                        <div ng-if="vm.contract.status == 3" class="tag-header terminated"><p>Terminated</p></div>
                        <div ng-if="vm.contract.status == 4" class="tag-header complete"><p>Completed</p></div>
                        <div class="card-body">
                            <div class="body-main">
                                <div class="img-badge">
                                    <img src="https://apps.annalect.com/static/img/shadow.png">
                                </div>
                                <div class="body-text">
                                    <p>Driver</p>
                                    <h4><a href="{{url('investor/drivers')}}/@{{ vm.contract.driver.id }}">@{{ vm.contract.driver.name }}</a></h4>
                                </div>
                                <div class="body-text">
                                    <p>Car</p>
                                    <h4><a href="{{url('investor/cars')}}/@{{ vm.contract.car.id }}">@{{ vm.contract.car.reg_no }}</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-body" ng-if="vm.contract_revenue_summary.length > 0">
                <h3>Revenue Overview</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>       </th>
                        <th ng-repeat="week in vm.contract_revenue_summary">Week @{{ week.week }}</th>

                    </tr>
                    <tr>
                        <td>Investor Revenue</td>
                        <td ng-repeat="week in vm.contract_revenue_summary"> @{{ week.revenue }}</td>

                    </tr>
                    <tr >
                        <td>Paid to investor</td>
                        <td ng-repeat="week in vm.contract_revenue_summary"
                            ng-click="setDetailWeek(week.week)"
                            class="pointer">
                            @{{ week.paid }}
                        </td>

                    </tr>
                    <tr>
                        <td>Balance</td>
                        <td ng-repeat="week in vm.contract_revenue_summary"> @{{ week.balance }}</td>

                    </tr>
                </table>
                <div class="heading">
                    <h4>*Subject to adjustments for VAT and other expenses</h4>
                </div>
            </div>
            <div class="detail-body-extension" ng-if="vm.contract_revenue_week_detail.length > 0">

                <h3>Week @{{ vm.contract_revenue_detail_week }} detail</h3>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Paid on</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr  ng-repeat="payment in vm.contract_revenue_week_detail">
                        <td>@{{  payment.date }}</td>
                        <td>@{{  payment.amount }}</td>
                    </tr>
                    </tbody>

                </table>

            </div>

            <div class="empty-detail-body" >
                <h1 ng-if="vm.contract.id == undefined">Please select a contract to view details</h1>
                <h1 ng-if="vm.contract.id > 0 && vm.contract_revenue_summary.length == 0">No payments recorded for this contract</h1>
            </div>
        </div>
    </div>



@endsection

@section('scripts')

    <script src="{{asset('Areas/Assets/Contract/module.js')}}"></script>
    <script src="{{asset('Areas/Assets/Contract/factory.js')}}"></script>
    <script src="{{asset('Areas/Assets/Contract/controller.js')}}"></script>
    <script src="{{asset('Areas/Assets/Contract/filters.js')}}"></script>
@endsection