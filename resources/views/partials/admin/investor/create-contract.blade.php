<div ng-if="vm.create.contract" class="card">
    <div class="card-body">
        <div class="lola">
            <div class="admin-flex-container main-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{--<input type="hidden" name="status" value="@{{ dirty.contract.status.value }}"--}}
                            {{--ng-model="dirty.contract.status.value">--}}
                            <label>Status</label>
                            <ui-select ng-model="dirty.contract.x_status">
                                <ui-select-match>
                                    <div class="select-group">
                                        <i class="fa fa-circle @{{ dirty.contract.x_status.key | lowercase }}"></i>
                                        <span ng-bind="dirty.contract.x_status.key"></span>
                                    </div>

                                </ui-select-match>
                                <ui-select-choices
                                        repeat="status in (vm.statuses | filter: $select.search) track by status.value">
                                    <div class="select-group">
                                        <i class="fa fa-circle @{{ status.key | lowercase }}"></i>
                                        <span ng-bind="status.key"></span>
                                    </div>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            {{--<input type="hidden" name="car" value="@{{ dirty.contract.car.id }}" ng-model="selected.car.id">--}}
                            <label>Car</label>
                            <ui-select ng-model="dirty.contract.car">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="dirty.contract.car.reg_no"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="car in (vm.investor.cars | filter: $select.search) track by car.id">
                                    <span ng-bind="car.reg_no +' ( '+ car.make+' )'"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                        <div class="form-group">
                            {{--<input type="hidden" name="driver" value="@{{ selected.driver.id }}"--}}
                            {{--ng-model="selected.driver.id">--}}
                            <label>Driver</label>
                            <ui-select ng-model="dirty.contract.driver">
                                <ui-select-match allow-clear="true">
                                    <span ng-bind="dirty.contract.driver.name"></span>
                                </ui-select-match>
                                <ui-select-choices
                                        repeat="driver in (vm.all_drivers | filter: $select.search) track by driver.id">
                                    <span ng-bind="driver.name +' ( '+ driver.license_no+' )'"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="dirty.contract.dt_start_date"
                                   is-open="dirty.contract.start_picker_open"
                                   datepicker-options="dateOptions.start_date"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="openStartPicker(dirty.contract)"/>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="text" class="form-control" uib-datepicker-popup
                                   ng-model="dirty.contract.dt_end_date"
                                   is-open="dirty.contract.end_picker_open" datepicker-options="dateOptions.end_date"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="openEndPicker(dirty.contract)"/>
                        </div>
                        <div class="form-group">
                            <label>Rent/Week (£)</label>
                            <input ng-model="dirty.contract.rate" class="form-control" placeholder="20">
                        </div>
                    </div>
                </div>


            </div>
            <div class="form-group footer">
                <div class="form-group button">

                    {{--<button type="button" class="btn  btn-default" ng-click="cancelAdd()">Cancel</button>--}}
                    <button type="button" class="btn  btn-primary" ng-click="newContract()">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>