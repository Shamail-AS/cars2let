@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/assets/layout.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row" ng-app="cars2let">
        <div class="col-md-2">
            <div id="left-side-bar" ng-controller="detailsController">
                <div class="overflow flex-container col">
                    <div class="pre-body">
                        <h3><a href="{{url('/admin/car/all')}}"><i class="fa fa-chevron-circle-left"></i> All
                            </a>/Car Details</h3>
                        <hr>
                    </div>

                    <div class="main-body">
                        <div ng-show="vm.loading" class="modal-cover">
                            <i class="fa fa-spinner fa-5x fa-spin"></i>
                        </div>

                        <div class="form-group">
                            <label>Reg #</label>
                            <input class="form-control" type="text" ng-model="vm.car.reg_no">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input class="form-control" type="text" ng-model="vm.car.price">
                        </div>
                        <div class="form-group">
                            <label>PCO Licence</label>
                            <input class="form-control" type="text" ng-model="vm.car.pco_licence">
                        </div>
                        <div class="form-group">
                            <label>PCO Expires At</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.x_pco_expires_at"
                                   is-open="vm.car.pco_expire_picker_open" datepicker-options="dateOptions.pco_expire"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.car.pco_expire_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Warranty Expires on</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.x_warranty_exp_at"
                                   is-open="vm.car.warranty_exp_picker_open"
                                   datepicker-options="dateOptions.warranty_exp"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.car.warranty_exp_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Roadside Assistance Expires on</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.x_roadside_exp_at"
                                   is-open="vm.car.x_roadside_exp_picker_open"
                                   datepicker-options="dateOptions.roadside_exp"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.car.x_roadside_exp_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Road Tax repay on</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.x_road_tax_exp_at"
                                   is-open="vm.car.x_road_tax_exp_picker_open"
                                   datepicker-options="dateOptions.road_tax_exp"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.car.x_road_tax_exp_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Current Odometer (Miles)</label>
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
                            <label>Colour</label>
                            <input class="form-control" type="text" ng-model="vm.car.colour">
                        </div>
                        <div class="form-group">
                            <label>Transmission</label>
                            <ui-select ng-model="vm.car.transmission">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="vm.car.transmission"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="transmission in (vm.transmissions | filter: $select.search) track by $index">
                                    <span ng-bind="transmission"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Fuel Type</label>
                            <ui-select ng-model="vm.car.fuel_type">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="vm.car.fuel_type"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="fuel in (vm.fuels | filter: $select.search) ">
                                    <span ng-bind="fuel"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Engine Details</label>
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
                            <ui-select ng-model="vm.car.status">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="vm.car.status"></span>
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
                                   ng-model="vm.car.x_available_since"
                                   is-open="vm.car.avail_since_picker_open" datepicker-options="dateOptions.avail_since"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.car.avail_since_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>First Reg Date</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="vm.car.x_first_reg_date"
                                   is-open="vm.car.first_reg_picker_open" datepicker-options="dateOptions.first_reg"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="vm.car.first_reg_picker_open = true"/>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <ui-select ng-model="vm.car.supplier">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="vm.car.supplier.name"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="supplier in (vm.suppliers | filter: $select.search) track by supplier.id">
                                    <span ng-bind="supplier.name"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            <label>Investor</label>
                            <ui-select ng-model="vm.car.investor">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="vm.car.investor.name"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="investor in (vm.investors | filter: $select.search) track by investor.id">
                                    <span ng-bind="investor.name"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>


                        <div class="form-group">
                            <label>On System Since</label>

                            <p class="">@{{ formatDate(vm.car.created_at) }}</p>
                        </div>

                        @if(Auth::user()->isEditOnly)
                            <button ng-click="updateCar(vm.car)" class="btn btn-block btn-success">
                                Update
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="mid-section">
                @include('admin.car.views.'.$page)
            </div>
        </div>
        <div class="col-md-2">
            <div id="right-side-bar" ng-controller="detailsController">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id)}}">Notifications</a></li>
                    {{--                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/contracts')}}">Contracts</a>--}}
                    </li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/tickets')}}">Tickets</a>
                    </li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/accidents')}}">Accidents</a>
                    </li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/services')}}">Service +
                            Repairs</a>
                    </li>
                    <li class="list-group-item"><a
                                href="{{url('admin/car/'.$car->id.'/view/deliveries')}}">Deliveries</a></li>
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/parts')}}">Tracker +
                            Camera</a></li>{{-- 
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/view/revenues')}}">Revenues</a> --}}
                    </li>
                    {{-- Addding car picture upload --}}
                    <li class="list-group-item"><a href="{{url('admin/car/'.$car->id.'/pictures')}}">Pictures</a>
                    </li>
                </ul>
                <div id="comments">
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="message" rows="2" cols="50" class="form-control" placeholder="Comments"
                                  ng-model="vm.car.comments">
                        </textarea>
                    </div>
                    <button class="btn btn-primary pull-right" ng-click="saveSelective(vm.car,'comments')">Save
                        Comments
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('Areas/Admin/Car/Details/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/Car/Details/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Car/Details/controller.js')}}"></script>
@endsection