@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row" ng-app="cars2let">
        <div class="col-md-3">
            <div id="left-side-bar" ng-controller="detailsController">
                <div class="overflow flex-container col">
                    <div class="pre-body">
                        <a href="{{url('/admin/car/all')}}"><i class="fa fa-chevron-circle-left fa-4x"></i>
                        </a>
                    </div>

                    <form class="main-body">
                        <div ng-show="vm.loading" class="modal-cover">
                            <i class="fa fa-spinner fa-5x fa-spin"></i>
                        </div>

                        <div class="form-group">
                            <label>Reg #</label>
                            <input class="form-control" type="text" ng-model="vm.car.reg_no">
                        </div>
                        <div class="form-group">
                            <label>PCO Licence</label>
                            <input class="form-control" type="text" ng-model="vm.car.pco_licence">
                        </div>
                        <div class="form-group">
                            <label>PCO Expires At</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.dt_pco_expires"
                                   is-open="vm.car.pco_expire_picker_open" datepicker-options="dateOptions.pco_expire"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="openPcoPicker(vm.car)"/>
                        </div>
                        <div class="form-group">
                            <label>Current Odometer</label>
                            <input class="form-control" type="text" ng-model="vm.car.curr_odo">
                        </div>
                        <div class="form-group">
                            <label>Make</label>
                            <input class="form-control" type="text" ng-model="vm.car.make">
                        </div>
                        <div class="form-group">
                            <label>Model</label>
                            <input class="form-control" type="text" ng-model="vm.car.model">
                        </div>
                        <div class="form-group">
                            <label>Year</label>
                            <input class="form-control" type="text" ng-model="vm.car.year">
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input class="form-control" type="text" ng-model="vm.car.color">
                        </div>
                        <div class="form-group">
                            <label>Transmission</label>
                            <ui-select ng-model="car.transmission">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="car.transmission"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="transmission in (vm.transmissions | filter: $select.search) track by $index">
                                    <span ng-bind="transmission"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Fuel Type</label>
                            <ui-select ng-model="car.fuel_type">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="car.fuel_type"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="fuel in (vm.fuels | filter: $select.search) track by $index">
                                    <span ng-bind="fuel"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Engine Size</label>
                            <input class="form-control" type="text" ng-model="vm.car.engine_size">
                        </div>
                        <div class="form-group">
                            <label>Chassis #</label>
                            <input class="form-control" type="text" ng-model="vm.car.chassis_num">
                        </div>
                        <div class="form-group">
                            <label>Keeper</label>
                            <input class="form-control" type="text" ng-model="vm.car.keeper">
                        </div>
                        <div class="form-group">
                            <label>Custom ID</label>
                            <input class="form-control" type="text" ng-model="vm.car.custom_id">
                        </div>
                        <div class="form-group">
                            <label>Current Status</label>
                            <ui-select ng-model="car.status">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="car.status"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="status in (vm.statuses | filter: $select.search) track by $index">
                                    <span ng-bind="status"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>

                        <div class="form-group">
                            <label>Available Since</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.dt_available_since"
                                   is-open="vm.car.avail_since_picker_open" datepicker-options="dateOptions.avail_since"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="openAvailSincePicker(vm.car)"/>
                        </div>
                        <div class="form-group">
                            <label>First Reg Date</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.dt_first_reg"
                                   is-open="vm.car.first_reg_picker_open" datepicker-options="dateOptions.first_reg"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="openFirstRegPicker(vm.car)"/>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <ui-select ng-model="car.supplier">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="car.supplier.name"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="supplier in (vm.suppliers | filter: $select.search) track by supplier.id">
                                    <span ng-bind="supplier.name"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Investor</label>
                            <ui-select ng-model="car.investor">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="car.investor.name"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="investor in (vm.investors | filter: $select.search) track by investor.id">
                                    <span ng-bind="investor.name"></span>
                                </ui-select-choices>
                            </ui-select>
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
        </div>
        <div class="col-md-7">
            <div id="mid-section">
                @include('admin.car.views.'.$page)
            </div>
        </div>
        <div class="col-md-2">
            <div id="right-side-bar">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id)}}">Overview</a></li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/contracts')}}">Contracts</a>
                    </li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/tickets')}}">Tickets</a>
                    </li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/alerts')}}">Alerts</a></li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/services')}}">Service/Repairs</a>
                    </li>
                    <li class="list-group-item"><a
                                href="{{url('admin/car/'.$car->id.'/view/deliveries')}}">Deliveries</a></li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/revenues')}}">Revenues</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('Areas/Admin/Car/Details/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/Car/Details/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Car/Details/controller.js')}}"></script>
@endsection