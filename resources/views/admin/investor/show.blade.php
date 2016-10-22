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
                               is-open="vm.investor.start_picker_open" datepicker-options="dateOptions"
                               ng-required="true"
                               close-text="Close"
                               ng-click="openStartPicker(vm.investor)"/>
                    </div>
                    <div class="form-group">
                        <label>Accounting Period End</label>
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.investor.dt_acc_period_end"
                               is-open="vm.investor.end_picker_open" datepicker-options="dateOptions"
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

                    <button ng-click="updateInvestor(vm.investor)" class="btn btn-xs btn-success">Update
                    </button>

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

                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search"
                                   ng-model="search.contracts">
                        </div>
                    </div>
                    <div class="admin-flex-container row grow">
                        <div class="table-container" ng-if="vm.investor.contracts.length > 0">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Car</th>
                                    <th>Driver</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Rent/Week (£)</th>
                                    <th>Created On</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="contract in vm.investor.contracts
                                | contractFilter : search.contracts">

                                    <td ng-if="contract.status == 1 && !contract.edit_mode"><i
                                                class="fa fa-circle ongoing"></i></td>
                                    <td ng-if="contract.status == 2 && !contract.edit_mode"><i
                                                class="fa fa-circle suspended"></i></td>
                                    <td ng-if="contract.status == 3 && !contract.edit_mode"><i
                                                class="fa fa-circle terminated"></i></td>
                                    <td ng-if="contract.status == 4 && !contract.edit_mode"><i
                                                class="fa fa-circle complete"></i></td>
                                    <td ng-if="contract.edit_mode">
                                        <ui-select ng-model="contract.x_status">
                                            <ui-select-match>
                                                <div class="select-group">
                                                    <i class="fa fa-circle @{{ contract.x_status.key | lowercase }}"></i>
                                                    <span ng-bind="contract.x_status.key"></span>
                                                </div>

                                            </ui-select-match>
                                            <ui-select-choices
                                                    repeat="status in (vm.statuses | filter: $select.search) track by status.value">
                                                <div class="select-group">
                                                    <i class="fa fa-circle @{{ status.key | lowercase }}"></i>
                                                    <span ng-bind="status.key"></span>
                                                </div>
                                            </ui-select-choices>
                                        </ui-select>
                                    </td>

                                    <td ng-if="!contract.edit_mode">@{{ contract.car.reg_no }}</td>
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

                                    <td ng-if="!contract.edit_mode">@{{ formatDate(contract.dt_start_date) }}</td>
                                    <td ng-if="contract.edit_mode">
                                        <input style="max-width: 110px;" type="text" class="form-control"
                                               uib-datepicker-popup
                                               ng-model="contract.dt_start_date"
                                               is-open="contract.start_picker_open"
                                               datepicker-options="dateOptions"
                                               ng-required="true"
                                               close-text="Close"
                                               ng-click="openStartPicker(contract)"/>
                                    </td>
                                    <td ng-if="!contract.edit_mode">@{{ formatDate(contract.dt_end_date) }}</td>
                                    <td ng-if="contract.edit_mode">
                                        <input style="max-width: 110px;" type="text" class="form-control"
                                               uib-datepicker-popup
                                               ng-model="contract.dt_end_date"
                                               is-open="contract.end_picker_open"
                                               datepicker-options="dateOptions"
                                               ng-required="true"
                                               close-text="Close"
                                               ng-click="openEndPicker(contract)"/>
                                    </td>

                                    <td style="max-width: 10px;"
                                        ng-if="!contract.edit_mode">@{{ contract.rate }}</td>
                                    <td ng-if="contract.edit_mode"><input style="max-width: 70px;"
                                                                          class="form-control" type="text"
                                                                          ng-model="contract.rate">
                                    </td>

                                    <td>@{{ formatDate(contract.created_at) }}</td>

                                    <td ng-if="!contract.edit_mode">
                                        <button type="button"
                                                class="btn btn-xs btn-@{{ contract.paying ? 'default' : 'info' }}"
                                                uib-popover-template="dynamicPopover.templateUrl"
                                                ng-click="togglePay(contract)">
                                            @{{ contract.paying ? 'Close' : 'Pay' }}
                                        </button>
                                        {{--<button ng-click="showRevenue(contract.id)" class="btn btn-xs btn-warning">Payments</button>--}}
                                        <button type="button"
                                                class="btn btn-xs btn-warning"
                                                uib-popover-template="dynamicPopover.revenueListUrl"
                                                popover-trigger="dynamicPopover.trigger"
                                                popover-placement="left-top"
                                                ng-click="showRevenue(contract.id)">
                                            Payments
                                        </button>
                                        @include('partials.admin.investor.create-rev')
                                        @include('partials.admin.investor.revenue-list')

                                    </td>
                                    <td>
                                        <div class="btn-group-xs">
                                            <button ng-if="!contract.edit_mode" ng-click="edit(contract)"
                                                    class="btn btn-xs btn-primary">Edit
                                            </button>
                                            <button ng-if="!contract.edit_mode"
                                                    ng-click="deleteObj(contract,'contract')"
                                                    class="btn btn-xs btn-danger">Delete
                                            </button>
                                            <button ng-if="contract.edit_mode" ng-click="updateContract(contract)"
                                                    class="btn btn-xs btn-warning">Update
                                            </button>
                                            <button ng-if="contract.edit_mode" ng-click="cancelEdit(contract)"
                                                    class="btn btn-xs btn-default">Cancel
                                            </button>
                                        </div>
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

            <div class="fixed-footer-button-container">
                <div class="card-container">
                    @include('partials.admin.investor.create-car')
                    @include('partials.admin.investor.create-contract')
                </div>
                <div class="admin-flex-container" ng-hide="active.drivers||active.revenues">
                    <span class="fixed-footer-button" ng-click="addNew()"><i class="fa fa-plus fa-2x"></i></span>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{asset('Areas/Admin/Investor/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/controller.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/filters.js')}}"></script>
@endsection