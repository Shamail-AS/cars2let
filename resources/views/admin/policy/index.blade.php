@extends("layouts.app")

@section("styles")

    <link href="{{asset('css/admin/admin.css')}}" rel="stylesheet">

@endsection

@section("content")
    <div class="wrapper" ng-app="cars2let" ng-controller="policyController">
        <h1>Manage Policies</h1>
        <table class="table table-striped">
            <tr>
                <th>Policy Number</th>
                <th>Company</th>
                <th>Excess</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Annual Insurance</th>
                <th></th>
                <th></th>
            </tr>
            <tr ng-repeat="policy in vm.policies | orderBy : '-id'">

                <td ng-if="!policy.edit_mode" >@{{ policy.policy_num }}</td>
                <td ng-if="policy.edit_mode"><input class="form-control" ng-model="policy.policy_num"></td>
                <td ng-if="!policy.edit_mode">@{{ policy.supplier.name }}</td>
                <td ng-if="policy.edit_mode">
                    <select class="form-control" ng-model="policy.insurance_comp">
                        @foreach($suppliers as $supplier)
                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                        @endforeach
                    </select>
                </td>
                
                <td ng-if="!policy.edit_mode">@{{ policy.excess }}</td>
                <td ng-if="policy.edit_mode"><input class="form-control" ng-model="policy.excess"></td>

                <td ng-if="!policy.edit_mode">@{{ policy.policy_start }}</td>
                <td ng-if="policy.edit_mode"><input class="form-control dp" ng-model="policy.policy_start"></td>

                <td ng-if="!policy.edit_mode">@{{ policy.policy_end }}</td>
                <td ng-if="policy.edit_mode"><input class="form-control dp" ng-model="policy.policy_end"></td>

                <td ng-if="!policy.edit_mode">@{{ policy.annual_insurance }}</td>
                <td ng-if="policy.edit_mode"><input class="form-control" ng-model="policy.annual_insurance"></td>

                <td>
                    @if(Auth::user()->isEditOnly)
                    <div class="btn-group-xs">
                        <button ng-if="!policy.edit_mode" ng-click="editPolicy(policy)"
                                class="btn btn-xs btn-primary">Edit
                        </button>
                        <button ng-if="policy.edit_mode" ng-click="updatePolicy(policy)" class="btn btn-xs btn-warning">
                            Update
                        </button>
                        <button ng-if="policy.edit_mode" ng-click="cancelEdit(policy)"
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
            @include('partials.form.policy-create',['admin'=>true])
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

    <script src="{{asset('Areas/Admin/Policy/module.js')}}"></script>
    {{--    <script src="{{asset('Areas/Admin/Policy/factory.js')}}"></script>--}}
    <script src="{{asset('Areas/Admin/Investor/factory.js')}}"></script>
    <script src="{{asset('Areas/Admin/Policy/controller.js')}}"></script>
@endsection