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

                    <p>All investors</p>
                </div>
                <div class="main-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
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
                        <tr ng-if="!vm.edit_mode">
                            <td>@{{ vm.investor.id }}</td>
                            <td>@{{ vm.investor.email }}</td>
                            <td>@{{ vm.investor.name }}</td>
                            <td>@{{ vm.investor.passport_num }}</td>
                            <td>@{{ vm.investor.dob }}</td>
                            <td>@{{ vm.investor.phone }}</td>
                            <td>@{{ vm.investor.created_at }}</td>
                            <td>@{{ vm.investor.tracking_url }}</td>

                        </tr>
                        <tr ng-if="vm.edit_mode">
                            <td>@{{ vm.investor.id }}</td>
                            <td><input type="text" ng-model="vm.investor.email"></td>
                            <td><input type="text" ng-model="vm.investor.name"></td>
                            <td><input type="text" ng-model="vm.investor.passport_num"></td>
                            <td><input type="text" ng-model="vm.investor.dob"></td>
                            <td><input type="text" ng-model="vm.investor.phone"></td>
                            <td>@{{ vm.investor.created_at }}</td>
                            <td><input type="text" ng-model="vm.investor.tracking_url"></td>

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="post-body">
                    <button ng-if="!vm.edit_mode" ng-click="editInvestor()" class="btn btn-xs btn-primary">Edit</button>
                    <button ng-if="vm.edit_mode" ng-click="cancelEdit()" class="btn btn-xs btn-default">Cancel</button>
                    <button ng-if="vm.edit_mode" ng-click="updateInvestor()" class="btn btn-xs btn-success">Update
                    </button>
                    <button ng-click="deleteInvestor()" class="btn btn-xs btn-danger">Delete</button>
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
                            <input class="form-control" placeholder="ABC-123">
                        </div>
                        <div class="form-group">
                            <label>Make</label>
                            <input class="form-control" placeholder="DivineRed">
                        </div>
                        <div class="form-group">
                            <label>Available Since</label>
                            <input type="date" class="form-control dp">
                        </div>
                        <div class="form-group">
                            <label>Comments</label>
                            <input class="form-control" placeholder="Comments...">
                        </div>
                        <div class="form-group button">

                            <button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>
                            <button type="button" class="btn  btn-primary">Save</button>
                        </div>

                    </div>
                    <div class="form-group footer"></div>
                </div>
                <div ng-if="vm.create.contract" class="item">
                    <div class="form-group main-body">
                        <div class="form-group">
                            <input type="hidden" name="status" value="@{{ selected.status.value }}"
                                   ng-model="selected.status.value">
                            <label>Status</label>
                            <ui-select ng-model="selected.status">
                                <ui-select-match>
                                    <div class="select-group">
                                        <i class="fa fa-circle @{{ selected.status.key | lowercase }}"></i>
                                        <span ng-bind="selected.status.key"></span>
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
                            <input type="hidden" name="car" value="@{{ selected.car.id }}" ng-model="selected.car.id">
                            <label>Car</label>
                            <ui-select ng-model="selected.car">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="selected.car.reg_no"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="car in (vm.investor.cars | filter: $select.search) track by car.id">
                                    <span ng-bind="car.reg_no +' ( '+ car.make+' )'"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="driver" value="@{{ selected.driver.id }}"
                                   ng-model="selected.driver.id">
                            <label>Driver</label>
                            <ui-select ng-model="selected.driver">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="selected.driver.name"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="driver in (vm.investor.drivers | filter: $select.search) track by driver.id">
                                    <span ng-bind="driver.name +' ( '+ driver.license_no+' )'"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" placeholder="2016/12/30">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" placeholder="2017/12/30">
                        </div>
                        <div class="form-group">
                            <label>Rent/Week (£)</label>
                            <input class="form-control" placeholder="20">
                        </div>
                        <div class="form-group button">

                            <button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>
                            <button type="button" class="btn  btn-primary">Save</button>
                        </div>

                    </div>
                    <div class="form-group footer"></div>
                </div>
                <div ng-if="vm.create.driver" class="item">
                    <div class="form-group main-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" placeholder="Adam">
                        </div>
                        <div class="form-group">
                            <label>License #</label>
                            <input class="form-control" placeholder="1231232">
                        </div>
                        <div class="form-group">
                            <label>PCO License #</label>
                            <input type="text" class="form-control" placeholder="1231232">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="someone'\@'example.com">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" placeholder="123-1232-2312">
                        </div>
                        <div class="form-group">
                            <label>Dob</label>
                            <input type="date" class="form-control" placeholder="1990-10-24">
                        </div>
                        <div class="form-group button">

                            <button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>
                            <button type="button" class="btn  btn-primary">Save</button>
                        </div>

                    </div>
                    <div class="form-group footer"></div>
                </div>
            </div>
            <div class="asset-body">
                <!--Revenues container-->
                <div ng-if="active.revenues" class="body-container">
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
                                <td>#</td>
                                <td>Contract #</td>
                                <td>Amount</td>
                                <td>Date Paid</td>
                                <td>Actual Paid</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="rev in vm.investor.revenues | filter : {id : search.revenues}">
                                <td>@{{ rev.id }}</td>
                                <td>@{{ rev.contract_id }}</td>
                                <td>@{{ rev.amount_paid }}</td>
                                <td>@{{ rev.paid_on }}</td>
                                <td>@{{ rev.created_at }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div ng-if="vm.investor.revenues.length == 0" class="placeholder">
                        Not payments recorded. Add a new payment from the 'plus' icon above
                    </div>
                </div>
                <!--Cars container-->
                <div ng-if="active.cars" class="body-container">
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
                                <td>Reg#</td>
                                <td>Make</td>
                                <td>Available Since</td>
                                <td>Active Contract#</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="car in vm.investor.cars
                            | filter : {reg_no : search.cars}
                            ">
                                <td>@{{car.reg_no}}</td>
                                <td>@{{ car.make }}</td>
                                <td>@{{ car.available_since }}</td>
                                <td>@{{ car.currentContract || 'None' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div ng-if="vm.investor.cars.length == 0" class="placeholder">
                        This investor doesn't have any Cars. Add a car by clicking the 'plus' icon above
                    </div>
                </div>
                <!--Contracts container-->
                <div ng-if="active.contracts" class="body-container">

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
                                <td>Status</td>
                                <td>Car#</td>
                                <td>Driver#</td>
                                <td>Start Date</td>
                                <td>End Date</td>
                                <td>Rent/Week (£)</td>
                                <td>Created On</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="contract in vm.investor.contracts

                            ">
                                <td ng-if="contract.status == 1"><i class="fa fa-circle ongoing"></i></td>
                                <td ng-if="contract.status == 2"><i class="fa fa-circle suspended"></i></td>
                                <td ng-if="contract.status == 3"><i class="fa fa-circle terminated"></i></td>
                                <td ng-if="contract.status == 4"><i class="fa fa-circle complete"></i></td>
                                <td>@{{ contract.car.reg_no }}</td>
                                <td>@{{ contract.driver.name }}</td>
                                <td>@{{ contract.start_date }}</td>
                                <td>@{{ contract.end_date }}</td>
                                <td>@{{ contract.rate }}</td>
                                <td>@{{ contract.created_at }}</td>
                                <td>
                                    <input class="form-control form-inline" ng-if="vm.paying == contract.id"
                                           ng-model="dirty.payment">
                                    <button ng-if="vm.paying != contract.id" ng-click="showPay(contract.id)"
                                            class="btn btn-xs btn-primary">Pay
                                    </button>
                                    <button ng-if="vm.paying == contract.id" ng-click="pay(contract.id)"
                                            class="btn btn-xs btn-danger">Pay
                                    </button>
                                    <button ng-if="vm.paying == contract.id" ng-click="cancelPay()"
                                            class="btn btn-xs btn-info">Cancel
                                    </button>
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
                <div ng-if="active.drivers" class="body-container">

                    <div class="header">
                        <div class="field">
                            <input class="form-control" type="text" placeholder="Search" ng-model="search.drivers">
                        </div>
                        <div class="action">
                            <i ng-click="add('driver')" class="fa fa-plus fa-2x"></i>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>License #</td>
                                <td>PCO License #</td>
                                <td>Email</td>
                                <td>Phone</td>
                                <td>Age</td>
                                <td>Registered Since</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="driver in vm.investor.drivers
                            | filter : {name : search.drivers}
                            ">
                                <td>@{{ driver.id }}</td>
                                <td>@{{ driver.name }}</td>
                                <td>@{{ driver.license_no }}</td>
                                <td>@{{ driver.pco_license_no }}</td>
                                <td>@{{ driver.email }}</td>
                                <td>@{{ driver.phone }}</td>
                                <td>@{{ getAge(driver.age) }}</td>
                                <td>@{{ driver.created_at }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div ng-if="vm.investor.drivers.length == 0" class="placeholder">
                        This investor doesn't have any related drivers. Create contracts to relate drivers to this
                        investor
                    </div>
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