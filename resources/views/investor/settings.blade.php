@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/admin/investor.css')}}" rel="stylesheet">

@endsection

@section('content')

    <div class="investor-flex-container">
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
                    {{--<button ng-click="cancelEdit(vm.investor)" class="btn btn-xs btn-default">Cancel--}}
                    {{--</button>--}}
                    <button ng-click="updateInvestor(vm.investor)" class="btn btn-xs btn-success">Update
                    </button>
                    {{--<button ng-click="edit(vm.investor)" class="btn btn-xs btn-primary">Edit</button>--}}
                    {{--<button ng-click="deleteObj(vm.investor,'investor')" class="btn btn-xs btn-danger">Delete--}}
                    {{--</button>--}}
                </form>


            </div>
        </div>
    </div>

@endsection