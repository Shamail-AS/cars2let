@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="wrapper" ng-app="cars2let" ng-controller="userController">
        <h1>Manage Users</h1>
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Status</th>
                <th>Type</th>
                <th>Register Since</th>
                <th>Actions</th>
            </tr>

            <tr ng-repeat="user in vm.users | orderBy : '-id'">
                <td>@{{ user.id }}</td>
                <td ng-if="!user.edit_mode">@{{ user.email }}</td>
                <td ng-if="user.edit_mode"><input class="form-control" ng-model="user.email"></td>
                <td ng-if="!user.edit_mode">@{{ user.status }}</td>
                <td ng-if="user.edit_mode ">
                    <ui-select ng-model="user.status">
                        <ui-select-match allow-clear="true">
                            <span ng-bind="user.status"></span>
                        </ui-select-match>
                        <ui-select-choices
                                repeat="status in (vm.statuses | filter: $select.search)">
                            <span ng-bind="status"></span>
                        </ui-select-choices>
                    </ui-select>
                </td>
                <td ng-if="!user.edit_mode">@{{ user.type || 'Unidentified'}}</td>
                <td ng-if="user.edit_mode">
                    <ui-select ng-model="user.type" ng-disabled="user.type == 'investor'">
                        <ui-select-match allow-clear="true">
                            <span ng-bind="user.type"></span>
                        </ui-select-match>
                        <ui-select-choices
                                repeat="type in (vm.types | filter: $select.search)">
                            <span ng-bind="type"></span>
                        </ui-select-choices>
                    </ui-select>
                </td>

                <td>@{{ formatDate(user.created_at) }}</td>
                <td>
                    <div class="btn-group-xs">
                        <button ng-if="!user.edit_mode" ng-click="editUser(user)" class="btn btn-xs btn-primary">Edit
                        </button>
                        <button ng-if="!user.edit_mode" ng-click="resetPassword(user)" class="btn btn-xs btn-danger">
                            Password reset
                        </button>
                        <button ng-if="user.edit_mode" ng-click="updateUser(user)" class="btn btn-xs btn-warning">Update
                        </button>
                        <button ng-if="user.edit_mode" ng-click="cancelEdit(user)" class="btn btn-xs btn-default">
                            Cancel
                        </button>
                    </div>
                </td>
            </tr>
        </table>
        <div class="fixed-footer-button-container">
            <div class="card-container">
                @include('partials.form.user-create')
            </div>
            <div class="flex-container">
                <span class="fixed-footer-button"><i class="fa fa-plus fa-2x"></i></span>
            </div>
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

    <script src="{{asset('Areas/Admin/User/module.js')}}"></script>
    <script src="{{asset('Areas/Admin/User/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/User/controller.js')}}"></script>
@endsection