<script type="text/ng-template" id="new-service.html">

    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create new Service Order</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>Type</label>
                                    <ui-select ng-model="order.type">
                                        <ui-select-match allow-clear="true">
                                            <span ng-bind="order.type"></span>
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="type in (vm.types | filter: $select.search) track by $index">
                                            <span ng-bind="type"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>

                                <div class="form-group">
                                    <label>Supplier</label>
                                    <ui-select ng-model="order.supplier">
                                        <ui-select-match allow-clear="true">
                                            <span ng-bind="order.supplier.name"></span>
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="supplier in (vm.suppliers | filter: $select.search | filter: order.type) track by $index">
                                            <span ng-bind="supplier.name"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>

                                <div class="form-group">
                                    <label>Booked For</label>
                                    {{--<input ng-model="order.issue_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="order.booked_dt"
                                           is-open="dirty.book_open"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="dirty.book_open = true"/>
                                </div>

                                <div class="form-group">
                                    <label>Cost</label>
                                    <input ng-model="order.cost" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Car</label>
                                <input ng-model="order.car.reg_no" readonly type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Handover Date (leave empty if NA)</label>
                                {{--<input ng-model="order.incident_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="order.incident_dt"
                                       is-open="dirty.incident_open"
                                       ng-required="true"
                                       close-text="Close"
                                       ng-click="dirty.incident_open = true"/>
                            </div>
                            <div class="form-group">
                                <label>Person Handed To</label>
                                <input ng-model="order.handover_person" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <ui-select ng-model="order.status">
                                    <ui-select-match allow-clear="true">
                                        <span ng-bind="order.status"></span>
                                    </ui-select-match>
                                    <ui-select-choices
                                            repeat="status in (vm.statuses | filter: $select.search) track by $index">
                                        <span ng-bind="status"></span>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea ng-model="order.comments" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div ng-if="order.type == 'REPAIR'" id="insurance">
                        <h4>Insurance Claim</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info">You can include insurance
                                    claim details later
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="delivery">
                        <h4>Future Return information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expected Return On</label>
                                    {{--<input ng-model="order.incident_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="order.delivery.scheduled_at"
                                           is-open="dirty.delivery.schedule_open"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="dirty.delivery.schedule_open = true"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expected Return Location</label>
                                    {{--<input ng-model="order.incident_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" ng-model="order.delivery.location"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Delivery Comments</label>
                                    <textarea ng-model="order.delivery.comments" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" ng-click="save()" class="btn btn-primary" data-dismiss="modal">Save
                        </button>
                        <button type="button" ng-click="close('No')" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

