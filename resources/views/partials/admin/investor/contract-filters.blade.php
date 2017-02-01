<script type="text/ng-template" id="contract-filters.html">

    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Define filters</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>Car</label>
                                    <input class="form-control" ng-model="filters.contract.car_reg">
                                </div>

                                <div class="form-group">
                                    <label>Driver</label>
                                    <input class="form-control" ng-model="filters.contract.driver_name">
                                </div>

                                <div class="form-group">
                                    <label>Planned Start Date</label>
                                    {{--<input ng-model="order.issue_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="filters.contract.start_date1"
                                           is-open="dirty.start1"
                                            {{--ng-required="true"--}}
                                           close-text="Close"
                                           ng-click="dirty.start1 = true"
                                           placeholder="Range start"/>
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="filters.contract.start_date2"
                                           is-open="dirty.start2"
                                            {{--ng-required="true"--}}
                                           close-text="Close"
                                           ng-click="dirty.start2 = true"
                                           placeholder="Range end"/>
                                </div>

                                <div class="form-group">
                                    <label>Planned End Date</label>
                                    {{--<input ng-model="order.issue_dt" type="text" class="form-control">--}}
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="filters.contract.end_date1"
                                           is-open="dirty.end1"
                                            {{--ng-required="true"--}}
                                           close-text="Close"
                                           ng-click="dirty.end1 = true"
                                           placeholder="Range start"/>
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="filters.contract.end_date2"
                                           is-open="dirty.end2"
                                            {{--ng-required="true"--}}
                                           close-text="Close"
                                           ng-click="dirty.end2 = true"
                                           placeholder="Range end"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <ui-select ng-model="filters.contract.x_status">
                                    <ui-select-match allow-clear="true">
                                        <span ng-bind="filters.contract.x_status.key"></span>
                                    </ui-select-match>
                                    <ui-select-choices
                                            repeat="status in (vm.statuses | filter: $select.search) track by $index">
                                        <span ng-bind="status.key"> </span>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                            <div class="form-group">
                                <label>Incomplete deposit</label>
                                <input type="checkbox" class="form-control" ng-model="filters.contract.low_deposit"/>
                            </div>
                            <div class="form-group">
                                <label>Actual Start Date</label>
                                {{--<input ng-model="order.issue_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="filters.contract.act_start_date1"
                                       is-open="dirty.act_start1"
                                        {{--ng-required="true"--}}
                                       close-text="Close"
                                       ng-click="dirty.act_start1 = true"
                                       placeholder="Range start"/>
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="filters.contract.act_start_date2"
                                       is-open="dirty.act_start2"
                                        {{--ng-required="true"--}}
                                       close-text="Close"
                                       ng-click="dirty.act_start2 = true"
                                       placeholder="Range end"/>
                            </div>

                            <div class="form-group">
                                <label>Actual End Date</label>
                                {{--<input ng-model="order.issue_dt" type="text" class="form-control">--}}
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="filters.contract.act_end_date1"
                                       is-open="dirty.act_end1"
                                        {{--ng-required="true"--}}
                                       close-text="Close"
                                       ng-click="dirty.act_end1 = true"
                                       placeholder="Range start"/>
                                <input type="text" class="form-control" uib-datepicker-popup
                                       ng-model="filters.contract.act_end_date2"
                                       is-open="dirty.act_end2"
                                        {{--ng-required="true"--}}
                                       close-text="Close"
                                       ng-click="dirty.act_end2 = true"
                                       placeholder="Range end"/>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" ng-click="reset()" class="btn btn-primary">Clear all
                        </button>
                        <button type="button" ng-click="close('No')" class="btn btn-default" data-dismiss="modal">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

