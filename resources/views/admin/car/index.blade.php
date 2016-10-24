@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="wrapper" ng-app="cars2let" ng-controller="carController">
        <h1>Manage Cars</h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Make</th>
                <th>Registration</th>
                <th>Investor</th>
                <th>Available Since</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody class="relative">

            <tr ng-repeat="car in vm.cars | orderBy : '-id'">
                <td>@{{ car.id }}</td>
                <td ng-if="!car.edit_mode">@{{ car.make }}</td>
                <td ng-if="car.edit_mode"><input class="form-control" ng-model="car.make"></td>
                <td ng-if="!car.edit_mode">@{{ car.reg_no }}</td>
                <td ng-if="car.edit_mode"><input class="form-control" ng-model="car.reg_no"></td>
                <td ng-if="!car.edit_mode">@{{ car.investor.name || 'Not linked'}}</td>
                <td ng-if="car.edit_mode">
                    <ui-select ng-model="car.investor">
                        <ui-select-match allow-clear="true">
                            <span ng-bind="car.investor.name"></span>
                        </ui-select-match>
                        <ui-select-choices
                                repeat="investor in (vm.investors | filter: $select.search) track by investor.id">
                            <span ng-bind="investor.name"></span>
                        </ui-select-choices>
                    </ui-select>
                </td>

                <td ng-if="!car.edit_mode">@{{ car.available_since }}</td>
                <td ng-if="car.edit_mode">
                    <input type="text" class="form-control" uib-datepicker-popup ng-model="car.dt_available_since"
                           is-open="car.picker_open" datepicker-options="dateOptions" ng-required="true"
                           close-text="Close"
                           ng-click="openPicker(car)"/>
                </td>
                <td ng-if="!car.edit_mode">@{{ car.comments }}</td>
                <td ng-if="car.edit_mode"><input class="form-control" ng-model="car.comments"></td>

                <td>
                    <div class="btn-group-xs">
                        <button ng-if="!car.edit_mode" ng-click="editCar(car)" class="btn btn-xs btn-primary">Edit
                        </button>
                        <button ng-if="car.edit_mode" ng-click="updateCar(car)" class="btn btn-xs btn-warning">Update
                        </button>
                        <button ng-if="car.edit_mode" ng-click="cancelEdit(car)" class="btn btn-xs btn-default">
                            Cancel
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div ng-if="vm.loading" class="placeholder">
            <span><i class="fa fa-spinner fa-3x fa-spin"></i></span>
        </div>
    </div>
    <div class="fixed-footer-button-container">
        <div class="card-container">
            @include('partials.form.car-create',['admin'=>true])
        </div>
        <div class="flex-container">
            <span class="fixed-footer-button"><i class="fa fa-plus fa-2x"></i></span>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        $().ready(function () {
            $('.fixed-footer-button').click(function () {
                $('.fixed-footer-button').toggleClass('clicked');
                $('.card-container').fadeToggle('fast');
                $('.extra-button').fadeToggle('fast');
            });
        });
    </script>

    <script src="{{asset('Areas/Admin/Car/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/Car/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Investor/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Car/controller.js')}}"></script>
@endsection