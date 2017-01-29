@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="wrapper" ng-app="cars2let" ng-controller="driverController">
        <h1>Manage Drivers</h1>
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Name</th>
                <th>License No.</th>
                <th>PCO License No.</th>
                <th>DOB</th>
                <th>Phone</th>
                <th>Joined</th>
                <th></th>
                <th></th>
            </tr>
            
            <tr ng-repeat="driver in vm.drivers | orderBy : '-id'">

                <td><a href="/admin/driver/@{{ driver.id }}">@{{ driver.id }}</a></td>
                <td ng-if="!driver.edit_mode"><a href="/admin/driver/@{{ driver.id }}">@{{ driver.email }}</a></td>
                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.email"></td>

                <td ng-if="!driver.edit_mode">@{{ driver.name }}</td>
                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.name"></td>

                <td ng-if="!driver.edit_mode">@{{ driver.license_no }}</td>
                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.license_no"></td>

                <td ng-if="!driver.edit_mode">@{{ driver.pco_license_no }}</td>
                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.pco_license_no"></td>

                <td ng-if="!driver.edit_mode">@{{ formatDate(driver.dob) }}</td>
                <td ng-if="driver.edit_mode">
                    <input type="text" class="form-control" uib-datepicker-popup ng-model="driver.dt_dob"
                           is-open="driver.picker_open" datepicker-options="dateOptions" ng-required="true"
                           close-text="Close"
                           ng-click="openPicker(driver)"/>
                </td>

                <td ng-if="!driver.edit_mode">@{{ driver.phone }}</td>
                <td ng-if="driver.edit_mode"><input class="form-control" ng-model="driver.phone"></td>

                <td>@{{ formatDate(driver.created_at) }}</td>

                <td>
                    @if(Auth::user()->isEditOnly)
                    <div class="btn-group-xs">
                        <button ng-if="!driver.edit_mode" ng-click="editDriver(driver)"
                                class="btn btn-xs btn-primary">Edit
                        </button>
                        <button ng-if="driver.edit_mode" ng-click="updateDriver(driver)" class="btn btn-xs btn-warning">
                            Update
                        </button>
                        <button ng-if="driver.edit_mode" ng-click="cancelEdit(driver)"
                                class="btn btn-xs btn-default">Cancel
                        </button>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="padded"></div>
                </td>
            </tr>
        </table>
        <div ng-if="vm.loading" class="placeholder">
            <span><i class="fa fa-spinner fa-3x fa-spin"></i></span>
        </div>
    </div>
    @if(Auth::user()->isFullAccess)
    <div class="fixed-footer-button-container">
        {{-- <div class="card-container">
            @include('partials.form.driver-create',['admin'=>true])
        </div> --}}
        <div class="flex-container">
            <a href="/cars/list"><span class="fixed-footer-button"><i class="fa fa-plus fa-2x"></i></span></a>
        </div>
    </div>
    @endif


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

    <script src="{{asset('Areas/Admin/Driver/module.js')}}"></script>
    {{--    <script src="{{asset('Areas/Admin/Driver/factory.js')}}"></script>--}}
    <script src="{{asset('Areas/Admin/Investor/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Driver/controller.js')}}"></script>
@endsection