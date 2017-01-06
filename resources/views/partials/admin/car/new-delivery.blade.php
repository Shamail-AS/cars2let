<script type="text/ng-template" id="new-delivery.html">

    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">New Delivery</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>Type</label>
                                    <ui-select ng-model="delivery.type">
                                        <ui-select-match allow-clear="true">
                                            <span ng-bind="delivery.type"></span>
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="type in (vm.types | filter: $select.search) track by $index">
                                            <span ng-bind="type"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <ui-select ng-model="delivery.status">
                                        <ui-select-match allow-clear="true">
                                            <span ng-bind="delivery.status"></span>
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="status in (vm.statuses | filter: $select.search ) track by $index">
                                            <span ng-bind="status"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>

                                <div class="form-group">
                                    <label>Scheduled For</label>
                                    {{--<input ng-model="delivery.issue_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="delivery.scheduled_at"
                                           is-open="dirty.schedule_open"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="dirty.schedule_open = true"/>
                                </div>

                                <div class="form-group">
                                    <label>Delivered At</label>
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="delivery.received_at"
                                           is-open="dirty.receive_open"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="dirty.receive_open = true"/>
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input ng-model="delivery.location" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Car</label>
                                <input ng-model="delivery.car.reg_no" readonly type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Condition</label>
                                <input ng-model="delivery.condition" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Odometer</label>
                                <input ng-model="delivery.odo_reading" type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Origin Order (Optional)</label>
                                <br>
                                <a href="#">@{{ delivery.order ? delivery.order.id : 'No associated order' }}</a>
                            </div>
                            <div class="form-group">
                                <label>Person Handed To</label>
                                <input ng-model="delivery.received_by" type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea ng-model="delivery.comments" class="form-control"></textarea>
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

