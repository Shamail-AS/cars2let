<script type="text/ng-template" id="new-ticket.html">

    <div class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create new Ticket</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ticket Number</label>
                                <input ng-model="ticket.ticket_num" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Driver</label>
                                <button ng-click="inferDriver()" class="btn btn-xs btn-primary">check</button>
                                <input ng-model="ticket.driver.name" readonly type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latest Due Date</label>
                                {{--<input ng-model="ticket.issue_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="ticket.latest_due_date"
                                       is-open="dirty.latest_due_date_open"
                                       ng-required="true"
                                       close-text="Close"
                                       ng-click="dirty.latest_due_date_open = true"/>
                            </div>        
                        </div>
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Actual Due Date</label>
                                {{--<input ng-model="ticket.issue_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="ticket.actual_due_date"
                                       is-open="dirty.actual_due_date_open"
                                       ng-required="true"
                                       close-text="Close"
                                       ng-click="dirty.actual_due_date_open = true"/>
                            </div> 
                        </div>
                        <div class="col-md-6">
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date Of Notice</label>
                                {{--<input ng-model="ticket.issue_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="ticket.date_of_notice"
                                       is-open="dirty.date_of_notice_open"
                                       ng-required="true"
                                       close-text="Close"
                                       ng-click="dirty.date_of_notice_open = true"/>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                {{--<input ng-model="ticket.status" type="text" class="form-control">--}}
                                <ui-select ng-model="ticket.type">
                                    <ui-select-match allow-clear="true">
                                        <span ng-bind="ticket.type"></span>
                                    </ui-select-match>
                                    <ui-select-choices
                                            repeat="type in (vm.types | filter: $select.search) track by $index">
                                        <span ng-bind="type"></span>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Website</label>
                                <input ng-model="ticket.website" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Paid Date</label>
                                {{--<input ng-model="ticket.issue_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="ticket.paid_date"
                                       is-open="dirty.paid_date_open"
                                       ng-required="true"
                                       close-text="Close"
                                       ng-click="dirty.paid_date_open = true"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input ng-model="ticket.amount" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Reference</label>
                                <input ng-model="ticket.payment_reference" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Liability of</label>
                                <input ng-model="ticket.liability_of" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Case Handler</label>
                                <input ng-model="ticket.case_handler" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Account</label>
                                <input ng-model="ticket.payment_account" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Authorized By</label>
                                <input ng-model="ticket.authorized_by" type="text" class="form-control">
                            </div>    
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
                </div>    

                    <div class="modal-footer">
                        <button type="button" ng-click="save()" class="btn btn-primary">Save
                        </button>
                        <button type="button" ng-click="close('No')" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
</script>

