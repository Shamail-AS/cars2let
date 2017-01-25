<link href="{{asset('css/admin/assets/car/overview.css')}}" rel="stylesheet">

<div id="wrapper" ng-controller="partsController">
    @include('partials.admin.car.new-delivery')
    <input type="hidden" id="csrf_token" ng-model="dirty.token" value="{{ csrf_token() }}">
    <div id="tracker">
        <h2>Tracker</h2>
        <hr>
        <div>
            <div class="row">
                <div class="col-md-4">
                    <strong>Current</strong>

                    <div ng-if="!(vm.tracker && vm.tracker.id)" class="alert alert-danger">No tracker linked with this
                        car
                    </div>
                    <div class="form-group">
                        <label>IMEI</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.imei">
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.model">
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        {{--<input class="form-control" type="text" ng-model="vm.tracker.supplier.name">--}}
                        <ui-select ng-model="vm.tracker.supplier">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.tracker.supplier.name"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="supplier in (vm.suppliers | filter: $select.search | filter: 'tracker') track by $index">
                                <span ng-bind="supplier.name"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>

                    <div class="form-group">
                        <label>Installed On</label>
                        {{--<input class="form-control" type="text" ng-model="vm.tracker.installed_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.tracker.installed_at"
                               is-open="dirty.tracker_ins"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.tracker_ins = true"/>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <ui-select ng-model="vm.tracker.status">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.tracker.status"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="status in (vm.statuses.tracker | filter: $select.search) track by $index">
                                <span ng-bind="status"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.comments">
                    </div>
                    <button ng-if="!(vm.tracker && vm.tracker.id)" ng-disabled="vm.tracker.loading"
                            class="btn btn-primary" ng-click="create('tracker')">
                        <i ng-if="vm.tracker.loading" class="fa fa-spin fa-circle-o-notch"></i> Save
                    </button>
                    <button ng-if="vm.tracker && vm.tracker.id" class="btn btn-success" ng-click="update('tracker')">
                        <i ng-if="vm.tracker.loading" class="fa fa-spin fa-circle-o-notch"></i> Update
                    </button>
                </div>
                <div ng-show="vm.tracker && vm.tracker.id" class="col-md-4">
                    <strong>Order</strong>

                    <div ng-if="!vm.tracker.order || !vm.tracker.order.id" class="alert alert-info">No order recorded
                        for this item
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <input class="form-control" readonly type="text" ng-model="vm.tracker.supplier.name">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <ui-select ng-model="vm.tracker.order.status">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.tracker.order.status"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="status in (vm.statuses.order | filter: $select.search) track by $index">
                                <span ng-bind="status"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                    <div class="form-group">
                        <label>Cost</label>
                        <input class="form-control" type="number" step="0.01" ng-model="vm.tracker.order.cost">
                    </div>
                    <div class="form-group">
                        <label>Authorized By</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.order.auth_user">
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.order.comments">
                    </div>
                    <button ng-if="!vm.tracker.order || !vm.tracker.order.id" ng-disabled="vm.tracker.order.loading"
                            ng-click="order('tracker')" class="btn btn-warning">
                        <i ng-if="vm.tracker.order.loading" class="fa fa-spin fa-circle-o-notch"></i>Save
                    </button>
                    <button ng-if="vm.tracker.order && vm.tracker.order.id" ng-click="updateOrder(vm.tracker.order)"
                            class="btn btn-warning">
                        <i ng-if="vm.tracker.order.loading" class="fa fa-spin fa-circle-o-notch"></i>Update
                    </button>
                </div>
                <div ng-show="vm.tracker.order && vm.tracker.order.id" class="col-md-4">
                    <strong>Delivery</strong>

                    <div ng-if="!vm.tracker.order.delivery || !vm.tracker.order.delivery.id"
                         class="alert alert-warning">No delivery recorded for this order
                    </div>
                    <div class="form-group">
                        <label>Scheduled for</label>
                        {{--<input class="form-control" type="text" ng-model="vm.tracker.order.delivery.scheduled_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.tracker.order.delivery.scheduled_at"
                               is-open="dirty.tracker_delivery"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.tracker_delivery = true"/>
                    </div>
                    <div class="form-group">
                        <label>Delivered At</label>
                        {{--<input class="form-control" type="text" ng-model="vm.tracker.order.delivery.delivered_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.tracker.order.delivery.delivered_at"
                               is-open="dirty.tracker_delivered"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.tracker_delivered = true"/>
                    </div>
                    <div class="form-group">
                        <label>Received By</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.order.delivery.received_by">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.order.delivery.location">
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.tracker.order.delivery.comments">
                    </div>
                    <button ng-disabled="vm.tracker.order.delivery.loading"
                            ng-if="!vm.tracker.order.delivery || !vm.tracker.order.delivery.id"
                            ng-click="deliver(vm.tracker.order)" class="btn btn-warning">Book Delivery
                    </button>
                    <button ng-if="vm.tracker.order.delivery && vm.tracker.order.delivery.id"
                            ng-click="updateDelivery(vm.tracker.order.delivery)" class="btn btn-warning">
                        <i ng-if="vm.tracker.order.delivery.loading" class="fa fa-spin fa-circle-o-notch"></i>Update
                    </button>
                </div>
            </div>
        </div>
        <br><br>
        <div id="sim">
            <h2>SIM</h2>
            <hr>
            <div ng-if="vm.tracker && vm.tracker.id" class="row">
                <div class="col-md-4">
                    <strong>Current</strong>

                    <div ng-if="!(vm.sim && vm.sim.id)" class="alert alert-danger">No SIM linked with this Tracker</div>

                    <div class="form-group">
                        <label>Number</label>
                        <input class="form-control" type="text" ng-model="vm.sim.number">
                    </div>
                    <div class="form-group">
                        <label>PUK</label>
                        <input class="form-control" type="text" ng-model="vm.sim.puk">
                    </div>
                    <div class="form-group">
                        <label>Passcode</label>
                        <input class="form-control" type="text" ng-model="vm.sim.passcode">
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <ui-select ng-model="vm.sim.supplier">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.sim.supplier.name"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="supplier in (vm.suppliers | filter: $select.search | filter: 'sim') track by $index">
                                <span ng-bind="supplier.name"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                    <button ng-if="!(vm.sim && vm.sim.id)" ng-disabled="vm.sim.loading" class="btn btn-primary"
                            ng-click="create('sim')">
                        <i ng-if="vm.sim.loading" class="fa fa-spin fa-circle-o-notch"></i>Save
                    </button>
                    <button ng-if="vm.sim && vm.sim.id" class="btn btn-success" ng-click="update('sim')">
                        <i ng-if="vm.sim.loading" class="fa fa-spin fa-circle-o-notch"></i>Update
                    </button>
                </div>
                <div ng-show="vm.sim && vm.sim.id" class="col-md-4">
                    <strong>Order</strong>

                    <div ng-if="!(vm.sim.order && vm.sim.order.id)" class="alert alert-info">No order recorded for this
                        item
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <input class="form-control" type="text" readonly ng-model="vm.sim.supplier.name">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <ui-select ng-model="vm.sim.order.status">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.sim.order.status"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="status in (vm.statuses.order | filter: $select.search) track by $index">
                                <span ng-bind="status"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                    <div class="form-group">
                        <label>Cost</label>
                        <input class="form-control" type="number" step="0.01" ng-model="vm.sim.order.cost">
                    </div>
                    <div class="form-group">
                        <label>Authorized By</label>
                        <input class="form-control" type="text" ng-model="vm.sim.order.auth_user">
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.sim.order.comments">
                    </div>
                    <button ng-if="!(vm.sim.order && vm.sim.order.id)" ng-disabled="vm.sim.order.loading"
                            ng-click="order('sim')" class="btn btn-warning">Save
                    </button>
                    <button ng-if="vm.sim.order && vm.sim.order.id" ng-click="updateOrder(vm.sim.order)"
                            class="btn btn-warning">
                        <i ng-if="vm.sim.order.loading" class="fa fa-spin fa-circle-o-notch"></i>Update
                    </button>
                </div>
                <div ng-show="vm.sim.order && vm.sim.order.id" class="col-md-4">
                    <strong>Delivery</strong>

                    <div ng-if="!(vm.sim.order.delivery && vm.sim.order.delivery.id)" class="alert alert-warning">No
                        delivery recorded for this item
                    </div>
                    <div class="form-group">
                        <label>Scheduled for</label>
                        {{--<input class="form-control" type="text" ng-model="vm.tracker.order.delivery.scheduled_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.sim.order.delivery.scheduled_at"
                               is-open="dirty.sim_delivery"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.sim_delivery = true"/>
                    </div>
                    <div class="form-group">
                        <label>Delivered At</label>
                        {{--<input class="form-control" type="text" ng-model="vm.sim.order.delivery.delivered_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.sim.order.delivery.delivered_at"
                               is-open="dirty.sim_delivered"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.sim_delivered = true"/>
                    </div>
                    <div class="form-group">
                        <label>Received By</label>
                        <input class="form-control" type="text" ng-model="vm.sim.order.delivery.received_by">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input class="form-control" type="text" ng-model="vm.sim.order.delivery.location">
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.sim.order.delivery.comments">
                    </div>
                    <button ng-if="!(vm.sim.order.delivery && vm.sim.order.delivery.id)"
                            ng-click="deliver(vm.sim.order)" class="btn btn-warning">Book Delivery
                    </button>
                    <button ng-if="vm.sim.order.delivery && vm.sim.order.delivery.id"
                            ng-click="updateDelivery(vm.sim.order.delivery)" class="btn btn-warning">Update
                    </button>

                </div>
            </div>
        </div>
    </div>

    <div id="Camera">
        <h2>Camera</h2>
        <hr>
        <div>
            <div class="row">
                <div class="col-md-4">
                    <strong>Current</strong>

                    <div ng-if="!(vm.camera && vm.camera.id)" class="alert alert-danger">No Camera linked with this
                        car
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <input class="form-control" type="text" ng-model="vm.camera.model">
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <ui-select ng-model="vm.camera.supplier">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.camera.supplier.name"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="supplier in (vm.suppliers | filter: $select.search | filter: 'camera') track by $index">
                                <span ng-bind="supplier.name"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                    <div class="form-group">
                        <label>Installed On</label>
                        {{--<input class="form-control" type="text" ng-model="vm.camera.installed_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.camera.installed_at"
                               is-open="dirty.camera_ins"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.camera_ins = true"/>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <ui-select ng-model="vm.camera.status">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.camera.status"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="status in (vm.statuses.camera | filter: $select.search) track by $index">
                                <span ng-bind="status"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.camera.comments">
                    </div>
                    <button ng-disabled="vm.camera.loading" ng-if="!(vm.camera && vm.camera.id)" class="btn btn-primary"
                            ng-click="create('camera')">
                        <i ng-if="vm.camera.loading" class="fa fa-spin fa-circle-o-notch"></i>Save
                    </button>
                    <button ng-if="vm.camera && vm.camera.id" class="btn btn-success" ng-click="update('camera')">
                        <i ng-if="vm.camera.loading" class="fa fa-spin fa-circle-o-notch"></i>Update
                    </button>
                </div>
                <div ng-show="vm.camera && vm.camera.id" class="col-md-4">
                    <strong>Order</strong>

                    <div ng-if="!(vm.camera.order && vm.camera.order.id)" class="alert alert-info">No order recorded for
                        this item
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <input class="form-control" readonly type="text" ng-model="vm.camera.supplier.name">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <ui-select ng-model="vm.camera.order.status">
                            <ui-select-match allow-clear="true">
                                <span ng-bind="vm.camera.order.status"></span>
                            </ui-select-match>
                            <ui-select-choices
                                    repeat="status in (vm.statuses.order | filter: $select.search) track by $index">
                                <span ng-bind="status"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                    <div class="form-group">
                        <label>Cost</label>
                        <input class="form-control" type="number" step="0.01" ng-model="vm.camera.order.cost">
                    </div>
                    <div class="form-group">
                        <label>Authorized By</label>
                        <input class="form-control" type="text" ng-model="vm.camera.order.auth_user">
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.camera.order.comments">
                    </div>
                    <button ng-if="!(vm.camera.order && vm.camera.order.id)" ng-disabled="vm.camera.order.loading"
                            ng-click="order('camera')" class="btn btn-warning">Save
                    </button>
                    <button ng-if="vm.camera.order && vm.camera.order.id" ng-click="updateOrder(vm.camera.order)"
                            class="btn btn-warning">
                        <i ng-if="vm.camera.order.loading" class="fa fa-spin fa-circle-o-notch"></i>Update
                    </button>
                </div>
                <div ng-show="vm.camera.order && vm.camera.order.id" class="col-md-4">
                    <strong>Delivery</strong>

                    <div ng-if="!(vm.camera.order.delivery && vm.camera.order.delivery.id)" class="alert alert-warning">
                        No delivery recorded for this item
                    </div>
                    <div class="form-group">
                        <label>Scheduled for</label>
                        {{--<input class="form-control" type="text" ng-model="vm.camera.order.delivery.scheduled_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.camera.order.delivery.scheduled_at"
                               is-open="dirty.camera_delivery"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.camera_delivery = true"/>
                    </div>
                    <div class="form-group">
                        <label>Delivered At</label>
                        {{--<input class="form-control" type="text" ng-model="vm.camera.order.delivery.delivered_at">--}}
                        <input type="text" class="form-control" uib-datepicker-popup
                               ng-model="vm.camera.order.delivery.delivered_at"
                               is-open="dirty.camera_delivered"
                               ng-required="true"
                               close-text="Close"
                               ng-click="dirty.camera_delivered = true"/>
                    </div>
                    <div class="form-group">
                        <label>Received By</label>
                        <input class="form-control" type="text" ng-model="vm.camera.order.delivery.received_by">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input class="form-control" type="text" ng-model="vm.camera.order.delivery.location">
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <input class="form-control" type="text" ng-model="vm.camera.order.delivery.comments">
                    </div>
                    <button ng-if="!(vm.camera.order.delivery && vm.camera.order.delivery.id)"
                            ng-click="deliver(vm.camera.order)" class="btn btn-warning">Book Delivery
                    </button>
                    <button ng-if="vm.camera.order.delivery && vm.camera.order.delivery.id"
                            ng-click="updateDelivery(vm.camera.order.delivery)" class="btn btn-warning">Update
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>