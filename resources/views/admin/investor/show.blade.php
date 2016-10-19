@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/investor.css')}}" rel="stylesheet">
    <link href="{{asset('css/sub_nav.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="col flex-container" ng-app="cars2let" ng-controller="investorController">
        <div class="profile-section">
            <div class="body flex-container row">
                <div class="pre-body">
                    <a href="{{url('/admin/investor/all')}}"><i class="fa fa-chevron-circle-left fa-4x"></i></a>
                    {{--<p>All investors</p>--}}
                </div>
                <div class="main-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Passport No.</th>
                            <th>DOB</th>
                            <th>Phone</th>
                            <th>Joined</th>
                            <th>Tracking URL</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-if="!vm.investor.edit_mode">
                            <td>@{{ vm.investor.email }}</td>
                            <td>@{{ vm.investor.name }}</td>
                            <td>@{{ vm.investor.passport_num }}</td>
                            <td>@{{ formatDate(vm.investor.dob) }}</td>
                            <td>@{{ vm.investor.phone }}</td>
                            <td>@{{ vm.investor.created_at }}</td>
                            <td>@{{ vm.investor.tracking_url }}</td>
                            <td>
                                <div class="btn-group-xs">
                                    <button ng-click="edit(vm.investor)" class="btn btn-xs btn-primary">Edit</button>
                                    <button ng-click="deleteObj(vm.investor,'investor')" class="btn btn-xs btn-danger">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr ng-if="vm.investor.edit_mode">
                            <td><input class="form-control" type="text" ng-model="vm.investor.email"></td>
                            <td><input class="form-control" type="text" ng-model="vm.investor.name"></td>
                            <td><input class="form-control" type="text" ng-model="vm.investor.passport_num"></td>
                            <td>
                                <p class="input-group">
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="vm.investor.dt_dob"
                                           is-open="vm.investor.picker_open" datepicker-options="dateOptions"
                                           ng-required="true"
                                           close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="openPicker(vm.investor)"><i
                                                class="fa fa-calendar"></i></button>
                                </span>
                                </p>
                            </td>
                            <td><input class="form-control" type="text" ng-model="vm.investor.phone"></td>
                            <td>@{{ vm.investor.created_at }}</td>
                            <td><input class="form-control" type="text" ng-model="vm.investor.tracking_url"></td>
                            <td>
                                <div class="btn-group-xs">
                                    <button ng-click="cancelEdit(vm.investor)" class="btn btn-xs btn-default">Cancel
                                    </button>
                                    <button ng-click="updateInvestor(vm.investor)" class="btn btn-xs btn-success">Update
                                    </button>
                                </div>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="post-body">
                </div>
            </div>
        </div>

        <div class="sub-nav">
            <div class="sub-nav-item" ng-class="{'active' : active.revenues}" ng-click="showRevenues()">
                Revenues
            </div>
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

        <div class="asset-section">
            <div class="asset-header">
                <div ng-if="vm.create.revenue" class="item">
                    <div class="form-group main-body">
                        <div class="form-group">
                            <label>Amount</label>
                            <input class="form-control" placeholder="amount" ng-model="dirty.revenue.amount">
                        </div>
                        <div class="form-group">
                            <label>Contract #</label>
                            <ui-select ng-model="dirty.revenue.contract">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="dirty.revenue.contract.id"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="contract in (vm.investor.contracts | filter: $select.search) track by contract.id">
                                    <span ng-bind="contract.car.reg_no + '/' + contract.driver.name"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group button">

                            <button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>
                            <button type="button" class="btn  btn-primary" ng-click="newRevenue()">Save</button>
                        </div>

                    </div>
                    <div class="form-group footer">

                    </div>

                </div>
                <div ng-if="vm.create.car" class="item">
                    <div class="form-group main-body">
                        <div class="form-group">
                            <label>Reg#</label>
                            <input ng-model="dirty.car.reg_no" class="form-control" placeholder="ABC-123">
                        </div>
                        <div class="form-group">
                            <label>Make</label>
                            <input ng-model="dirty.car.make" class="form-control" placeholder="DivineRed">
                        </div>
                        <div class="form-group">
                            <label>Available Since</label>

                            <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="dirty.car.dt_available_since"
                                       is-open="dirty.car.picker_open" datepicker-options="dateOptions"
                                       ng-required="true"
                                       close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="openPicker(dirty.car)"><i
                                                class="fa fa-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Comments</label>
                            <input ng-model="dirty.car.comments" class="form-control" placeholder="Comments...">
                        </div>
                        <div class="form-group button">

                            <button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>
                            <button type="button" class="btn  btn-primary" ng-click="newCar()">Save</button>
                        </div>

                    </div>
                    <div class="form-group footer"></div>
                </div>
                <div ng-if="vm.create.contract" class="item">
                    <form class="form-group main-body">
                        <div class="form-group">
                            {{--<input type="hidden" name="status" value="@{{ dirty.contract.status.value }}"--}}
                            {{--ng-model="dirty.contract.status.value">--}}
                            <label>Status</label>
                            <ui-select ng-model="dirty.contract.x_status">
                                <ui-select-match>
                                    <div class="select-group">
                                        <i class="fa fa-circle @{{ dirty.contract.x_status.key | lowercase }}"></i>
                                        <span ng-bind="dirty.contract.x_status.key"></span>
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
                        </div>
                        <div class="form-group">
                            {{--<input type="hidden" name="car" value="@{{ dirty.contract.car.id }}" ng-model="selected.car.id">--}}
                            <label>Car</label>
                            <ui-select ng-model="dirty.contract.car">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="dirty.contract.car.reg_no"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="car in (vm.investor.cars | filter: $select.search) track by car.id">
                                    <span ng-bind="car.reg_no +' ( '+ car.make+' )'"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            {{--<input type="hidden" name="driver" value="@{{ selected.driver.id }}"--}}
                            {{--ng-model="selected.driver.id">--}}
                            <label>Driver</label>
                            <ui-select ng-model="dirty.contract.driver">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="dirty.contract.driver.name"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="driver in (vm.all_drivers | filter: $select.search) track by driver.id">
                                    <span ng-bind="driver.name +' ( '+ driver.license_no+' )'"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>

                            <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="dirty.contract.dt_start_date"
                                       is-open="dirty.contract.start_picker_open" datepicker-options="dateOptions"
                                       ng-required="true"
                                       close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"
                                            ng-click="openStartPicker(dirty.contract)"><i
                                                class="fa fa-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>

                            <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="dirty.contract.dt_end_date"
                                       is-open="dirty.contract.end_picker_open" datepicker-options="dateOptions"
                                       ng-required="true"
                                       close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"
                                            ng-click="openEndPicker(dirty.contract)"><i
                                                class="fa fa-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Rent/Week (£)</label>
                            <input ng-model="dirty.contract.rate" class="form-control" placeholder="20">
                        </div>
                        <div class="form-group button">

                            <button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>
                            <button type="button" class="btn  btn-primary" ng-click="newContract()">Save</button>
                        </div>

                    </form>
                    <div class="form-group footer"></div>
                </div>
                <div ng-if="vm.create.driver" class="item">
                    <div class="form-group main-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input ng-model="dirty.driver.name" class="form-control" placeholder="Adam">
                        </div>
                        <div class="form-group">
                            <label>License #</label>
                            <input ng-model="dirty.driver.license_no" class="form-control" placeholder="1231232">
                        </div>
                        <div class="form-group">
                            <label>PCO License #</label>
                            <input ng-model="dirty.driver.pco_license_no" type="text" class="form-control"
                                   placeholder="1231232">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input ng-model="dirty.driver.email" type="email" class="form-control"
                                   placeholder="someone'\@'example.com">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input ng-model="dirty.driver.phone" class="form-control" placeholder="123-1232-2312">
                        </div>
                        <div class="form-group">
                            <label>Dob</label>

                            <p class="input-group">
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="dirty.driver.dt_dob"
                                       is-open="dirty.driver.picker_open" datepicker-options="dateOptions"
                                       ng-required="true"
                                       close-text="Close"/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="openPicker(dirty.driver)"><i
                                                class="fa fa-calendar"></i></button>
                                </span>
                            </p>
                        </div>
                        <div class="form-group button">

                            <button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>
                            <button type="button" class="btn  btn-primary" ng-click="newDriver()">Save</button>
                        </div>

                    </div>
                    <div class="form-group footer"></div>
                </div>
            </div>
            <div class="asset-body">
                <!--Revenues container-->
                <div ng-if="active.revenues && !active.loading" class="body-container">
                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search" ng-model="search.revenues">
                        </div>
                        <div class="action">
                            <i ng-click="add('revenue')" class="fa fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Contract #</th>
                                <th>Amount</th>
                                <th>Paid On</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="rev in vm.investor.revenues | filter : {id : search.revenues}">
                                <td>@{{ rev.id }}</td>

                                <td ng-if="!rev.edit_mode">@{{ rev.contract_id }}</td>
                                <td ng-if="rev.edit_mode"><input class="form-control" ng-model="rev.contract_id"></td>

                                <td ng-if="!rev.edit_mode">@{{ rev.amount_paid }}</td>
                                <td ng-if="rev.edit_mode"><input class="form-control" ng-model="rev.amount_paid"></td>

                                <td>@{{ formatDate(rev.created_at) }}</td>

                                <td>
                                    <div class="btn-group-xs">
                                        <button ng-if="!rev.edit_mode" ng-click="edit(rev)"
                                                class="btn btn-xs btn-primary">Edit
                                        </button>
                                        <button ng-if="!rev.edit_mode" ng-click="deleteObj(rev,'revenue')"
                                                class="btn btn-xs btn-danger">Delete
                                        </button>
                                        <button ng-if="rev.edit_mode" ng-click="updateRev(rev)"
                                                class="btn btn-xs btn-warning">Update
                                        </button>
                                        <button ng-if="rev.edit_mode" ng-click="cancelEdit(rev)"
                                                class="btn btn-xs btn-default">Cancel
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div ng-if="vm.investor.revenues.length == 0" class="placeholder">
                        No payments recorded. Add a new payment from the 'plus' icon above
                    </div>
                </div>
                <!--Cars container-->
                <div ng-if="active.cars && !active.loading" class="body-container">
                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search" ng-model="search.cars">
                        </div>
                        <div class="action">
                            <i ng-click="add('car')" class="fa fa-plus fa-2x"></i>
                        </div>
                    </div>
                    <div class="table-container">
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
                                    <p class="input-group">
                                        <input type="text" class="form-control" uib-datepicker-popup
                                               ng-model="car.dt_available_since"
                                               is-open="car.picker_open" datepicker-options="dateOptions"
                                               ng-required="true"
                                               close-text="Close"/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default"
                                                    ng-click="openPicker(car)">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </p>
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
                        This investor doesn't have any Cars. Add a car by clicking the 'plus' icon above
                    </div>
                </div>
                <!--Contracts container-->
                <div ng-if="active.contracts && !active.loading" class="body-container">

                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search" ng-model="search.contracts">
                        </div>
                        <div class="action">
                            <i ng-click="add('contract')" class="fa fa-plus fa-2x"></i>
                        </div>
                    </div>
                    <div class="table-container">
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

                            ">
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
                                    <ui-select ng-model="contract.car">
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
                                    <ui-select ng-model="contract.driver">
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
                                    <p class="input-group">
                                        <input type="text" class="form-control" uib-datepicker-popup
                                               ng-model="contract.dt_start_date"
                                               is-open="contract.start_picker_open" datepicker-options="dateOptions"
                                               ng-required="true"
                                               close-text="Close"/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default"
                                                    ng-click="openStartPicker(contract)">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </p>
                                </td>
                                <td ng-if="!contract.edit_mode">@{{ formatDate(contract.dt_end_date) }}</td>
                                <td ng-if="contract.edit_mode">
                                    <p class="input-group">
                                        <input type="text" class="form-control" uib-datepicker-popup
                                               ng-model="contract.dt_end_date"
                                               is-open="contract.end_picker_open" datepicker-options="dateOptions"
                                               ng-required="true"
                                               close-text="Close"/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default"
                                                    ng-click="openEndPicker(contract)">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </p>
                                </td>

                                <td ng-if="!contract.edit_mode">@{{ contract.rate }}</td>
                                <td ng-if="contract.edit_mode"><input class="form-control" ng-model="contract.rate">
                                </td>

                                <td>@{{ formatDate(contract.created_at) }}</td>

                                <td ng-if="!contract.edit_mode">
                                    <input class="form-control form-inline" ng-if="contract.paying"
                                           ng-model="contract.payment">
                                    <button ng-if="!contract.paying" ng-click="showPay(contract)"
                                            class="btn btn-xs btn-primary">Pay
                                    </button>
                                    <button ng-if="contract.paying" ng-click="pay(contract)"
                                            class="btn btn-xs btn-danger">Pay
                                    </button>
                                    <button ng-if="contract.paying" ng-click="cancelPay(contract)"
                                            class="btn btn-xs btn-info">Cancel
                                    </button>
                                </td>
                                <td>
                                    <div class="btn-group-xs">
                                        <button ng-if="!contract.edit_mode" ng-click="edit(contract)"
                                                class="btn btn-xs btn-primary">Edit
                                        </button>
                                        <button ng-if="!contract.edit_mode" ng-click="deleteObj(contract,'contract')"
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
                    <div ng-if="vm.investor.contracts.length == 0" class="placeholder">
                        This investor doesn't have any contracts. Click the plus icon to create one now.
                    </div>
                </div>
                <!--Drivers container-->
                <div ng-if="active.drivers && !active.loading" class="body-container">

                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search" ng-model="search.drivers">
                        </div>
                        {{--<div class="action">--}}
                        {{--<i ng-click="add('driver')" class="fa fa-plus fa-2x"></i>--}}
                        {{--</div>--}}
                    </div>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
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
                            | filter : {name : search.drivers}
                            ">
                                <td>@{{ driver.id }}</td>

                                <td ng-if="!driver.edit_mode">@{{ driver.name }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.name"></td>

                                <td ng-if="!driver.edit_mode">@{{ driver.license_no }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.license_no">
                                </td>

                                <td ng-if="!driver.edit_mode">@{{ driver.pco_license_no }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control"
                                                                    ng-model="driver.pco_license_no"></td>

                                <td ng-if="!driver.edit_mode">@{{ driver.email }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.email"></td>

                                <td ng-if="!driver.edit_mode">@{{ driver.phone }}</td>
                                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.phone"></td>

                                <td ng-if="!driver.edit_mode">@{{ getAge(driver.dob) }}</td>
                                <td ng-if="driver.edit_mode">
                                    <p class="input-group">
                                        <input type="text" class="form-control" uib-datepicker-popup
                                               ng-model="driver.dt_dob"
                                               is-open="driver.picker_open" datepicker-options="dateOptions"
                                               ng-required="true"
                                               close-text="Close"/>
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-default"
                                                                            ng-click="openPicker(driver)"><i
                                                                                class="fa fa-calendar"></i></button>
                                                                </span>
                                    </p>
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
                        This investor doesn't have any related drivers. Create contracts to relate drivers to this
                        investor
                    </div>
                </div>

                <div ng-if="active.loading" class="placeholder">
                    <span><i class="fa fa-spinner fa-3x fa-spin"></i></span>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')


    <script src="{{asset('Areas/Admin/Investor/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/controller.js')}}"></script>
@endsection