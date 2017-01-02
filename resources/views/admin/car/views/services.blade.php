<div>
    <div id="wrapper" ng-controller="servicesController">
        <h1><a href="{{url('/admin/car/all')}}"><i class="fa fa-chevron-circle-left"></i> All Cars
            </a> / Services + Repairs</h1>
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
                    <th>Insurance</th>
                    <th>Actions</th>
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
                    <td>@{{ order.insurance.id }}</td>
                    <td>
                        <button class="btn btn-xs btn-primary" ng-click="editorder(order)">Edit</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>