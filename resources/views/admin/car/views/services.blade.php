<div>
    <div id="wrapper" ng-controller="servicesController">
        <h1> Services + Repairs</h1>
        <hr>
        <div id="tickets">
            @include('partials.admin.car.new-service')
            <button class="btn btn-primary btn-block" ng-click="newOrder()"> New Service / Repair</button>
            <input type="hidden" id="csrf_token" ng-model="dirty.token" value="{{ csrf_token() }}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Authorized By</th>
                    <th>Booked for</th>
                    <th>Type</th>
                    <th>Cost</th>
                    <th>Handover At</th>
                    <th>Handed to</th>
                    <th>Status</th>
                    <th>Comments</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="order in vm.orders">
                    <td>@{{ order.supplier.name }}</td>
                    <td>@{{ order.auth_user }}</td>
                    <td>@{{ formatDate(order.booked_dt )}}</td>
                    <td>@{{ order.type }}</td>
                    <td>@{{ order.cost }}</td>
                    <td>@{{ formatDate(order.handover_dt) }}</td>
                    <td>@{{ (order.handover_person) }}</td>
                    <td>@{{ order.status }}</td>
                    <td>@{{ order.comments }}</td>
                    <td>
                        <button class="btn btn-xs btn-primary" ng-click="editOrder(order)">Edit</button>
                        <a ng-if="order.insurance_claim_id"
                           href="{{url('admin/service_orders/insurance')}}/@{{ order.id }}"
                           class="btn btn-xs btn-info">Insurance</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>