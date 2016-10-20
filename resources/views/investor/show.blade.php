@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/investor.css')}}" rel="stylesheet">

@endsection

@section('content')

    <div class="investor-flex-container" ng-app="cars2let" ng-controller="investorController">
        <div class="profile-section" style="flex: 1 0 auto">
            <div class="body investor-flex-container col">
                <div class="alert alert-info">Here you can modify your general details, including your <strong>Accounting
                        Period</strong></div>
                <form class="main-body">
                    <div class="row">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
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

                        </div>
                    </div>
                    <div ng-show="vm.investor.loading" class="modal-cover">
                        <i class="fa fa-spinner fa-5x fa-spin"></i>
                    </div>

                    <div class="form-group">
                        <label>Registered Since</label>
                        <p class="">@{{ formatDate(vm.investor.created_at) }}</p>
                    </div>
                    <button ng-click="updateInvestor(vm.investor)" class="btn btn-lg btn-block btn-success">Update
                    </button>
                    <button ng-click="toDashBoard()" class="btn btn-lg btn-block btn-info">Cancel</button>

                </form>


            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        var app = angular.module('cars2let', ['angularMoment', 'ui.bootstrap']);
        app.controller('investorController', ['$scope', '$http', 'moment', function ($scope, $http, moment) {

            $scope.vm = {
                investor: {}
            };
            $scope.openPicker = function (obj) {
                obj.picker_open = true;
            };
            $scope.openStartPicker = function (obj) {
                obj.start_picker_open = true;
            };
            $scope.openEndPicker = function (obj) {
                obj.end_picker_open = true;
            };
            $scope.getAge = function (date) {
                return moment(date).fromNow(true);
            };
            $scope.formatDate = function (date) {
                return moment(date).format("DD, MMM YYYY");
            };
            $scope.toDashBoard = function () {
                window.history.back();
            };
            $scope.updateInvestor = function (investor) {
                var id = investor.id;

                investor.loading = true;
                investor.dob = moment(investor.dt_dob).format("DD-MM-YYYY");
                investor.acc_period_start = moment(investor.dt_acc_period_start).format("DD-MM-YYYY");
                investor.acc_period_end = moment(investor.dt_acc_period_end).format("DD-MM-YYYY");
                investorDataFactory.updateInvestor(id, investor)
                        .success(function () {
                            investor.loading = false;
                        });
            };

            var load_investor = function (id) {
                $scope.vm.investor.loading = true;
                $http.get('/api/admin/investors/' + id)
                        .success(function (investor) {
                            investor.dt_dob = moment(investor.dob).toDate();
                            investor.dt_acc_period_start = moment(investor.acc_period_start).toDate();
                            investor.dt_acc_period_end = moment(investor.acc_period_end).toDate();
                            $scope.vm.investor = investor;
                            $scope.vm.investor.loading = false;
                        });
            };
            var init = function () {
                var url = (window.location.pathname);
                var id = _.takeRight(_.split(url, '/'))[0];
                if (id)
                    load_investor(id);
            };

            init();
        }]);
    </script>
@endsection