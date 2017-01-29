@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="wrapper" ng-app="cars2let" ng-controller="supplierController">
        <h1>Manage Suppliers</h1>
        <table class="table table-striped">
            <tr>
                <th>Name</th>
                <th>Contact Name</th>
                <th>Contact Details</th>
                <th>Type</th>
                <th></th>
                <th></th>
            </tr>
            <tr ng-repeat="supplier in vm.suppliers | orderBy : '-id'">

                <td ng-if="!supplier.edit_mode">@{{ supplier.name }}</td>
                <td ng-if="supplier.edit_mode"><input class="form-control" ng-model="supplier.name"></td>
                
                <td ng-if="!supplier.edit_mode">@{{ supplier.contact_name }}</td>
                <td ng-if="supplier.edit_mode"><input class="form-control" ng-model="supplier.contact_name"></td>

                <td ng-if="!supplier.edit_mode">@{{ supplier.contact_details }}</td>
                <td ng-if="supplier.edit_mode"><input class="form-control" ng-model="supplier.contact_details"></td>

                <td ng-if="!supplier.edit_mode">@{{ supplier.type }}</td>
                <td ng-if="supplier.edit_mode">
                <select class="form-control" ng-model="supplier.type">
                    <option value="car">Car</option>
                    <option value="tracker">Tracker</option>
                    <option value="sim">Sim</option>
                    <option value="camera">Camera</option>
                    <option value="garage">Garage</option>
                    <option value="insurance">Insurance</option>
                    <option value="mot">Mot</option>
                    <option value="pco">Pco</option>
                    <option value="road-side">Road-Side</option>
                    <option value="road-side">Repairs</option>
                </select>
                </td>
                <td>
                    @if(Auth::user()->isEditOnly)
                    <div class="btn-group-xs">
                        <button ng-if="!supplier.edit_mode" ng-click="editsupplier(supplier)"
                                class="btn btn-xs btn-primary">Edit
                        </button>
                        <button ng-if="!supplier.edit_mode" ng-click="deletesupplier(supplier)"
                                class="btn btn-xs btn-danger">Delete
                        <button ng-if="supplier.edit_mode" ng-click="updatesupplier(supplier)" class="btn btn-xs btn-warning">
                            Update
                        </button>
                        <button ng-if="supplier.edit_mode" ng-click="cancelsupplier(supplier)"
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
        <div class="card-container">
            @include('partials.form.supplier-create',['admin'=>true])
        </div>
        <div class="flex-container">
            <span class="fixed-footer-button"><i class="fa fa-plus fa-2x"></i></span>
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

    <script src="{{asset('Areas/Admin/Supplier/module.js')}}"></script>
    {{--    <script src="{{asset('Areas/Admin/Supplier/factory.js')}}"></script>--}}
    <script src="{{asset('Areas/Admin/Investor/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Supplier/controller.js')}}"></script>
@endsection