<div>
    <div id="wrapper" ng-controller="deliveriesController">
        <h1>Deliveries</h1>
        <hr>
        <div id="tickets">
            @include('partials.admin.car.new-delivery')
            <button class="btn btn-primary btn-block" ng-click="newDelivery()"> Record new Delivery</button>
            <input type="hidden" id="csrf_token" ng-model="dirty.token" value="{{ csrf_token() }}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Type</th>
                    <th>Scheduled At</th>
                    <th>Received At</th>
                    <th>Received By</th>
                    <th>Location</th>
                    <th>Condition</th>
                    <th>Comments</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="delivery in vm.deliveries">
                    <td>@{{ delivery.order.id || 'No Order' }}</td>
                    <td>@{{ delivery.type == 'other' ? delivery.other_type : delivery.type }}</td>
                    <td>@{{ formatDate(delivery.scheduled_at )}}</td>
                    <td>@{{ formatDate(delivery.delivered_at )}}</td>
                    <td>@{{ delivery.received_by }}</td>
                    <td>@{{ delivery.location }}</td>
                    <td>@{{ delivery.condition }}</td>

                    <td>@{{ delivery.comments }}</td>
                    <td>
                        <button class="btn btn-xs btn-primary" ng-click="editDelivery(delivery)">Edit</button>
                        <button class="btn btn-xs btn-danger" ng-click="deleteDelivery(delivery)">Delete</button>{{-- 
                        <a href="{{url('admin/deliveries')}}/@{{ delivery.id }}" class="btn btn-xs btn-info">Details</a> --}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>