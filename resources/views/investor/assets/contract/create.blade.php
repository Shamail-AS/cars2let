@extends('layouts.app')

@section("styles")
    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">
    <link href="{{asset('css/investor_car_details.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="card-container centered" ng-app="contractForm" ng-controller="formController">
        <div class="card">
            <div class="card-header suspended">
                <h1>Register a new contract</h1>
            </div>
            <div class="card-body">
                <form class="form" method="POST" action="{{url('/investor/assets/contract/store')}}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label>Start Date</label>
                        <input class="form-control dp" type="hidden" name="start_date" placeholder=""
                               value="@{{ formatDate(dirty.start_date) }}">
                        <input style="max-width: 110px;" type="text" class="form-control"
                               uib-datepicker-popup
                               ng-model="dirty.start_date"
                               is-open="dirty.start_picker_open"
                               datepicker-options="dateOptions.start_date"
                               ng-required="true"
                               close-text="Close"
                               ng-click="openStartPicker()"/>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input class="form-control dp" type="hidden" name="end_date" placeholder=""
                               value="@{{ formatDate(dirty.end_date) }}">
                        <input style="max-width: 110px;" type="text" class="form-control"
                               uib-datepicker-popup
                               ng-model="dirty.end_date"
                               is-open="dirty.end_picker_open"
                               datepicker-options="dateOptions.end_date"
                               ng-required="true"
                               close-text="Close"
                               ng-click="openEndPicker()"/>
                    </div>

                    {{-- <div class="form-group">
                        <input type="hidden"  name="status" value="@{{ selected.status.value }}" ng-model="selected.status.value">
                        <label>Status</label>
                        <ui-select ng-model="selected.status">
                            <ui-select-match >
                                <div class="select-group">
                                    <i class="fa fa-circle @{{ selected.status.key | lowercase }}"></i>
                                    <span ng-bind="selected.status.key"></span>
                                </div>

                            </ui-select-match>
                            <ui-select-choices repeat="status in (vm.statuses | filter: $select.search) track by status.value">
                                <div class="select-group">
                                    <i class="fa fa-circle @{{ status.key | lowercase }}"></i>
                                    <span ng-bind="status.key"></span>
                                </div>
                            </ui-select-choices>
                        </ui-select>
                    </div> --}}


                    <div class="form-group">
                        <input type="hidden"  name="car" value="@{{ selected.car.id }}" ng-model="selected.car.id">
                        <label>Car</label>
                        <ui-select ng-model="selected.car" ng-change="addprice(selected.car)">
                            <ui-select-match allow-clear="true" >
                                <span ng-bind="selected.car.reg_no"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="car in (vm.cars | filter: $select.search) track by car.id">
                                <span ng-bind="car.reg_no +' ( '+ car.make+' )'"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>

                    <div class="form-group">
                        <input type="hidden"  name="driver" value="@{{ selected.driver.id }}" ng-model="selected.driver.id">
                        <label>Driver</label>
                        <ui-select ng-model="selected.driver">
                            <ui-select-match allow-clear="true" >
                                <span ng-bind="selected.driver.name"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="driver in (vm.drivers | filter: $select.search) track by driver.id">
                                <span ng-bind="driver.name +' ( '+ driver.license_no+' )'"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>


                    <div class="form-group">
                        <label>Per week rate (£)</label>
                        <input class="form-control" type="number" name="rate" id="rate" value="{{old('rate')}}">
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="button" class="btn btn-warning" onclick="window.history.back()">
                                <i class="fa fa-btn fa-times"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-file-text-o"></i>Submit For Approval
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var app = angular.module('contractForm', ['ui.select', 'ngSanitize', 'ui.bootstrap', 'angularMoment']);
    var controller = app.controller('formController', ['$scope', 'moment', function ($scope, moment) {
        $scope.vm = {
            "cars":[],
            "drivers":[],
            "statuses":[]
        };
        $scope.selected = {
            "car":{},
            "driver":{},
            "status":{}
        };
        $scope.dirty = {
            'start_date': {},
            'end_date': {}
        };
        $scope.dateOptions = {
            'start_date': {
                'minDate': new Date(),
                'maxDate': {}
            },
            'end_date': {
                'minDate': {}
            }

        };
        $scope.formatDate = function (value) {
            return moment(value).format("DD-MM-YYYY");
        }
        $scope.openEndPicker = function () {
            $scope.dirty.end_picker_open = true;
            $scope.dateOptions.end_date.minDate = $scope.dirty.start_date;

        }
        $scope.openStartPicker = function () {
            $scope.dirty.start_picker_open = true;
            $scope.dateOptions.start_date.maxDate = $scope.dirty.end_date;
        }

        $scope.addprice = function(selectedcar) {
            console.log(selectedcar.price);
            $('#rate').val(selectedcar.price);
        };

        var init = function(){
            $.get("/api/car/all").success(function(data){
               $scope.vm.cars = data;
            });
            $.get("/api/drivers").success(function (data) {
                $scope.vm.drivers = data;
            });
            $scope.vm.statuses.push({"key":"Ongoing","value":1});
            $scope.vm.statuses.push({"key":"Suspended","value":2});
            $scope.vm.statuses.push({"key":"Terminated","value":3});
            $scope.vm.statuses.push({"key":"Complete","value":4});
            $scope.selected.status = $scope.vm.statuses[0];
        };

        init();
    }]);
</script>
@endsection