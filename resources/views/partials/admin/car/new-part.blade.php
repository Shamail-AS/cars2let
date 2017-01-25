<script type="text/ng-template" id="new-tracker.html">

    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create new Camera</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>Ticket Number</label>
                                    <input ng-model="ticket.ticket_num" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Cause</label>
                                    {{--<input ng-model="ticket.cause" type="text" class="form-control">--}}
                                    <ui-select ng-model="ticket.cause">
                                        <ui-select-match allow-clear="true">
                                            <span ng-bind="ticket.cause"></span>
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="cause in (vm.causes | filter: $select.search) track by $index">
                                            <span ng-bind="cause"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>

                                <div class="form-group">
                                    <label>Issued On</label>
                                    {{--<input ng-model="ticket.issue_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="ticket.issue_dt"
                                           is-open="dirty.issue_open"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="dirty.issue_open = true"/>
                                </div>

                                <div class="form-group">
                                    <label>Amount</label>
                                    <input ng-model="ticket.amount" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Car</label>
                                <input ng-model="ticket.car.reg_no" readonly type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Incident Date</label>
                                {{--<input ng-model="ticket.incident_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="ticket.incident_dt"
                                       is-open="dirty.incident_open"
                                       ng-required="true"
                                       close-text="Close"
                                       ng-click="dirty.incident_open = true"/>
                            </div>
                            <div class="form-group">
                                <label>Driver</label>
                                <button ng-click="inferDriver()" class="btn btn-xs btn-primary">check</button>
                                <input ng-model="ticket.driver.name" readonly type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                {{--<input ng-model="ticket.status" type="text" class="form-control">--}}
                                <ui-select ng-model="ticket.status">
                                    <ui-select-match allow-clear="true">
                                        <span ng-bind="ticket.status"></span>
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
                            {{--<form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >--}}
                            {{--<input type="hidden" name="_token" value="{{ csrf_token()}}">--}}
                            {{--<div class="form-group">--}}
                            {{--<input type="file" class="form-control" name="image" multiple>--}}
                            {{--</div>--}}
                            {{--</form>--}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea ng-model="ticket.comments" class="form-control"></textarea>
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
<script type="text/ng-template" id="new-sim"></script>
<script type="text/ng-template" id="new-camera"></script>
