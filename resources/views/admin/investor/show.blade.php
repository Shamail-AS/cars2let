@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/investor.css')}}" rel="stylesheet">
    <link href="{{asset('css/sub_nav.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section('content')

    <div class="investor-flex-container" ng-app="cars2let" ng-controller="investorController">
        <div class="profile-section">
            <div class="body investor-flex-container col">

                <div class="pre-body">
                    <a href="{{url('/admin/investor/all')}}"><i class="fa fa-chevron-circle-left fa-4x"></i>
                    </a>
                </div>

                <form class="main-body">
                    <div ng-show="vm.investor.loading" class="modal-cover">
                        <i class="fa fa-spinner fa-5x fa-spin"></i>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" ng-model="vm.investor.email">
                    </div>
                    <div class="form-group">
                        <label>Tracker URL</label>
                        <input class="form-control" type="text" ng-model="vm.investor.tracking_url">
                    </div>
                    <div class="form-group">
                        <label>Accounting Period Start</label>
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.investor.dt_acc_period_start"
                               is-open="vm.investor.start_picker_open" datepicker-options="dateOptions.acc_period_start"
                               ng-required="true"
                               close-text="Close"
                               ng-click="openStartPicker(vm.investor)"/>
                    </div>
                    <div class="form-group">
                        <label>Accounting Period End</label>
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.investor.dt_acc_period_end"
                               is-open="vm.investor.end_picker_open" datepicker-options="dateOptions.acc_period_end"
                               ng-required="true"
                               close-text="Close"
                               ng-click="openEndPicker(vm.investor)"/>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" ng-model="vm.investor.name">
                    </div>
                    <div class="form-group">
                        <label>Passport</label>
                        <input class="form-control" type="text" ng-model="vm.investor.passport_num">
                    </div>
                    <div class="form-group">
                        <label>DoB</label>
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.investor.dt_dob"
                               is-open="vm.investor.picker_open" datepicker-options="dateOptions"
                               ng-required="true"
                               close-text="Close"
                               ng-click="openPicker(vm.investor)"/>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control" type="text" ng-model="vm.investor.phone">
                    </div>

                    <div class="form-group">
                        <label>Registered Since</label>

                        <p class="">@{{ formatDate(vm.investor.created_at) }}</p>
                    </div>

                    @if(Auth::user()->isEditOnly)
                        <button ng-click="updateInvestor(vm.investor)" class="btn btn-xs btn-success">
                            Update
                    </button>
                    @endif

                </form>


            </div>
        </div>

        <div class="col investor-flex-container grow">

            <div class="sub-nav">

                <div class="sub-nav-item" ng-class="{'active' : active.cars}" ng-click="showCars()">
                    Cars
                </div>
                <div class="sub-nav-item" ng-class="{'active' : active.contracts}" ng-click="showContracts()">
                    Contracts
                </div>
                <div class="sub-nav-item" ng-class="{'active' : active.drivers}" ng-click="showDrivers()">
                    Drivers
                </div>

            </div>

            <div class="asset-section asset-body">
                <!--Cars container-->
                <div ng-if="active.cars && !active.loading" class="body-container">
                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search" ng-model="search.cars">
                        </div>
                    </div>
                    <div class="table-container" ng-if="vm.investor.cars.length > 0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Reg #</th>
                                <th>Make</th>
                                <th>Available Since</th>
                                <th>Active Contract #</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="car in vm.investor.cars
                            | filter : {reg_no : search.cars}
                            | orderBy : '-id'
                            ">
                                <td ng-if="!car.edit_mode">@{{ car.reg_no }}</td>
                                <td ng-if="car.edit_mode"><input class="form-control" ng-model="car.reg_no"></td>

                                <td ng-if="!car.edit_mode">@{{ car.make }}</td>
                                <td ng-if="car.edit_mode"><input class="form-control" ng-model="car.make"></td>

                                <td ng-if="!car.edit_mode">@{{ formatDate(car.dt_available_since)}}</td>
                                <td ng-if="car.edit_mode">
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="car.dt_available_since"
                                           is-open="car.picker_open" datepicker-options="dateOptions"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="openPicker(car)"/>
                                </td>

                                <td>@{{ car.currentContract.id || 'None' }}</td>


                                <td>
                                    @if(Auth::user()->isEditOnly)
                                    <div class="btn-group-xs">
                                        <button ng-if="!car.edit_mode" ng-click="edit(car)"
                                                class="btn btn-xs btn-primary">Edit
                                        </button>
                                        <button ng-if="!car.edit_mode" ng-click="deleteObj(car,'car')"
                                                class="btn btn-xs btn-danger">Delete
                                        </button>
                                        <button ng-if="car.edit_mode" ng-click="updateCar(car)"
                                                class="btn btn-xs btn-warning">Update
                                        </button>
                                        <button ng-if="car.edit_mode" ng-click="cancelEdit(car)"
                                                class="btn btn-xs btn-default">Cancel
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div ng-if="vm.investor.cars.length == 0" class="placeholder">
                        <p>This investor doesn't have any Cars. </p>

                        <p>Add a car by clicking the 'plus' icon</p>
                    </div>
                </div>
                <!--Contracts container-->
                <div ng-if="active.contracts && !active.loading" class="body-container">
                    <button ng-click="openFilters()" class="btn btn-primary">
                        Filters
                    </button>

                    <div class="header">
                        <div class="field">

                        </div>

                    </div>

                    <div class="admin-flex-container row grow">
                        <div class="table-container" ng-if="vm.investor.contracts.length > 0">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Car<i ng-if="filters.contract.car_reg.length > 0"
                                              class="fa fa-filter terminated"></i></th>
                                    <th>Driver<i ng-if="filters.contract.driver_name.length > 0"
                                                 class="fa fa-filter terminated"></i></th>
                                    <th>Start Date
                                        <i ng-if="filters.contract.start_date1 || filters.contract.start_date2"
                                           class="fa fa-filter terminated"></i>
                                        [Actual]
                                        <i ng-if="filters.contract.act_start_date1 || filters.contract.act_start_date2"
                                           class="fa fa-filter terminated"></i>
                                    </th>
                                    <th>End Date
                                        <i ng-if="filters.contract.end_date1 || filters.contract.end_date2"
                                           class="fa fa-filter terminated"></i>
                                        [Actual]
                                        <i ng-if="filters.contract.act_end_date1 || filters.contract.act_end_date2"
                                           class="fa fa-filter terminated"></i></th>
                                    <th>Rent/Week (£)</th>
                                    <th>Deposit (£)</th>
                                    <th>Created On</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="contract in (vm.investor.contracts
                                | newContractFilter : filters.contract | orderBy : '-id') track by contract.id">

                                    <td>
                                        <i ng-if="contract.loading" class="fa fa-spinner fa-spin"></i>
                                        <span style="margin-right: 10px">
                                            <i ng-if="contract.status == 1" class="fa fa-circle ongoing"></i>
                                            <i ng-if="contract.status == 2" class="fa fa-circle new"></i>
                                            <i ng-if="contract.status == 3" class="fa fa-circle terminated"></i>
                                            <i ng-if="contract.status == 4" class="fa fa-circle complete"></i>
                                        </span>

                                        <button ng-if="contract.status == 2"
                                                ng-disabled="!contract.canStart"
                                                class="btn btn-xs btn-warning"
                                                ng-click="contractAction(contract,'start')">Start
                                        </button>
                                        <i ng-if="!contract.canStart && contract.status == 2"
                                           class="fa fa-info-circle complete"
                                           uib-tooltip="@{{ contract.canStart ? '' : 'Can\'t start before planned start' }}"></i>
                                        <button ng-if="contract.status <= 2" class="btn btn-xs btn-danger"
                                                ng-click="contractAction(contract,'end')">End
                                        </button>
                                    </td>

                                    <td ng-if="!contract.edit_mode"><a
                                                ng-href="@{{ '/admin/car/' + contract.car.id }}">@{{ contract.car.reg_no }}</a>
                                    </td>
                                    <td ng-if="contract.edit_mode">
                                        <ui-select style="min-width: 120px;" ng-model="contract.car">
                                            <ui-select-match allow-clear="true">
                                                <span ng-bind="contract.car.reg_no"></span>
                                            </ui-select-match>
                                            <ui-select-choices
                                                    repeat="car in (vm.investor.cars | filter: $select.search) track by car.id">
                                                <span ng-bind="car.reg_no +' ( '+ car.make+' )'"></span>
                                            </ui-select-choices>
                                        </ui-select>
                                    </td>

                                    <td ng-if="!contract.edit_mode">@{{ contract.driver.name }}</td>
                                    <td ng-if="contract.edit_mode">
                                        <ui-select style="min-width: 100px;" ng-model="contract.driver">
                                            <ui-select-match allow-clear="true">
                                                <span ng-bind="contract.driver.name"></span>
                                            </ui-select-match>
                                            <ui-select-choices
                                                    repeat="driver in (vm.all_drivers | filter: $select.search) track by driver.id">
                                                <span ng-bind="driver.name +' ( '+ driver.license_no+' )'"></span>
                                            </ui-select-choices>
                                        </ui-select>
                                    </td>

                                    <td ng-if="!contract.edit_mode">@{{ formatDate(contract.dt_start_date) }}
                                        [@{{ formatDate(contract.act_start_dt) }}]
                                    </td>
                                    <td ng-if="contract.edit_mode">
                                        <input style="max-width: 110px;" type="text" class="form-control"
                                               uib-datepicker-popup
                                               ng-model="contract.dt_start_date"
                                               is-open="contract.start_picker_open"
                                               datepicker-options="dateOptions.start_date"
                                               ng-required="true"
                                               close-text="Close"
                                               ng-click="openStartPicker(contract)"/>
                                    </td>
                                    <td ng-if="!contract.edit_mode">@{{ formatDate(contract.dt_end_date) }}
                                        [@{{ formatDate(contract.act_end_dt) }}]
                                    </td>
                                    <td ng-if="contract.edit_mode">
                                        <input style="max-width: 110px;" type="text" class="form-control"
                                               uib-datepicker-popup
                                               ng-model="contract.dt_end_date"
                                               is-open="contract.end_picker_open"
                                               datepicker-options="dateOptions.end_date"
                                               ng-required="true"
                                               close-text="Close"
                                               ng-click="openEndPicker(contract)"/>
                                    </td>

                                    <td style="max-width: 10px;"
                                        ng-if="!contract.edit_mode">@{{ contract.rate | number : 2}}</td>
                                    <td ng-if="contract.edit_mode"><input style="max-width: 70px;"
                                                                          class="form-control" type="text"
                                                                          ng-model="contract.rate">

                                    <td style="max-width: 10px;"
                                        ng-if="!contract.edit_mode">@{{ contract.rec_deposit | number : 0}}
                                        /@{{ contract.req_deposit | number : 0 }}</td>
                                    <td ng-if="contract.edit_mode"><input style="max-width: 70px;"
                                                                          class="form-control" type="text"
                                                                          ng-model="contract.rec_deposit">/<input
                                                style="max-width: 70px;"
                                                class="form-control" type="text"
                                                ng-model="contract.req_deposit">
                                    </td>

                                    <td>@{{ formatDate(contract.created_at) }}</td>

                                    <td ng-if="!contract.edit_mode">
                                        <button type="button"
                                                class="btn btn-xs btn-warning"
                                                ng-click="openPayments(contract)">
                                            Payments
                                        </button>

                                        <button ng-click="openRentAllocs(contract)" class="btn btn-xs btn-primary">
                                            Rent alloc
                                            </button>

                                        @include('partials.admin.investor.contract-rent')
                                        @include('partials.admin.investor.contract-filters')
                                        @include('partials.admin.investor.contract-payment')

                                    </td>
                                    <td>
                                        @if(Auth::user()->isEditOnly)
                                        <div class="btn-group-xs">
                                            <button ng-if="!contract.edit_mode && contract.status == 2"
                                                    ng-click="edit(contract)"
                                                    class="btn btn-xs btn-primary">Edit
                                            </button>
                                            <a ng-href="@{{ contract.outUrl }}" ng-if="contract.outHandover"
                                               class="btn btn-xs btn-success">Out</a>
                                            <a ng-href="@{{ contract.inUrl }}" ng-if="contract.inHandover"
                                               class="btn btn-xs btn-success">In</a>
                                            <a ng-href="@{{ contract.handoverCreateUrl }}"
                                               ng-if="!contract.outHandover || !contract.inHandover"
                                               class="btn btn-xs btn-info">Create</a>

                                            <button ng-if="contract.edit_mode" ng-click="updateContract(contract)"
                                                    class="btn btn-xs btn-warning">Update
                                            </button>
                                            <button ng-if="contract.edit_mode" ng-click="cancelEdit(contract)"
                                                    class="btn btn-xs btn-default">Cancel
                                            </button>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div ng-if="vm.investor.contracts.length == 0" class="placeholder">
                        <p>This investor doesn't have any contracts.</p>

                        <p> Click the plus icon to create one now</p>
                    </div>
                </div>
                <!--Drivers container-->
                <div ng-if="active.drivers && !active.loading" class="body-container">

                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search" ng-model="search.drivers">
                        </div>
                    </div>
                    <div class="table-container" ng-if="vm.investor.drivers.length > 0">
                        <table class="table table-striped reduced">
                            <thead>
                            <tr>
                                {{--<th>#</th>--}}
                                <th>Name</th>
                                <th>License #</th>
                                <th>PCO License #</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Age</th>
                                <th>Registered Since</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="driver in vm.investor.drivers
                            | driverFilter : search.drivers
                            ">
                                {{--                                    <td>@{{ driver.id }}</td>--}}

                                <td ng-if="!driver.edit_mode">@{{ driver.name }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.name">
                                </td>

                                <td ng-if="!driver.edit_mode">@{{ driver.license_no }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control"
                                                                    ng-model="driver.license_no">
                                </td>

                                <td ng-if="!driver.edit_mode">@{{ driver.pco_license_no }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control"
                                                                    ng-model="driver.pco_license_no"></td>

                                <td style="max-width: 130px;" ng-if="!driver.edit_mode">@{{ driver.email }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.email">
                                </td>

                                <td ng-if="!driver.edit_mode">@{{ driver.phone }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.phone">
                                </td>

                                <td ng-if="!driver.edit_mode">@{{ getAge(driver.dob) }}</td>
                                <td ng-if="driver.edit_mode">
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="driver.dt_dob"
                                           is-open="driver.picker_open" datepicker-options="dateOptions"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="openPicker(driver)"/>
                                </td>
                                <td>@{{ formatDate(driver.created_at) }}</td>
                                <td>
                                    @if(Auth::user()->isEditOnly)
                                    <div class="btn-group-xs">
                                        <button ng-if="!driver.edit_mode" ng-click="edit(driver)"
                                                class="btn btn-xs btn-primary">
                                            Edit
                                        </button>
                                        <button ng-if="!driver.edit_mode" ng-click="deleteObj(driver,'driver')"
                                                class="btn btn-xs btn-danger">
                                            Delete
                                        </button>
                                        <button ng-if="driver.edit_mode" ng-click="updateDriver(driver)"
                                                class="btn btn-xs btn-warning">Update
                                        </button>
                                        <button ng-if="driver.edit_mode" ng-click="cancelEdit(driver)"
                                                class="btn btn-xs btn-default">Cancel
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div ng-if="vm.investor.drivers.length == 0" class="placeholder">
                        <p>This investor doesn't have any related drivers.</p>

                        <p> Create contracts to relate drivers</p>
                    </div>
                </div>

                <div ng-if="active.loading" class="placeholder">
                    <span><i class="fa fa-spinner fa-3x fa-spin"></i></span>
                </div>

            </div>

            @if(Auth::user()->isFullAccess)
            <div class="fixed-footer-button-container">
                <div class="card-container">
                    @include('partials.admin.investor.create-car')
                    @include('partials.admin.investor.create-contract')
                </div>
                <div class="admin-flex-container" ng-hide="active.drivers||active.revenues">
                    <span class="fixed-footer-button" ng-click="addNew()"><i class="fa fa-plus fa-2x"></i></span>
                </div>
            </div>
            @endif

        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{asset('Areas/Admin/Investor/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/modal-controllers.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/controller.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/filters.js')}}"></script>
@endsection