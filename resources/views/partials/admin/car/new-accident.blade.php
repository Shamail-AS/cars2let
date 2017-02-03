<script type="text/ng-template" id="new-accident.html">

    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Record Accident</h4>
                </div>
                <div class="modal-body">
                    <div class="row" tag="mycar">
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>Car</label>
                                    <input class="form-control" readonly ng-model="vm.car.reg_no">
                                </div>
                                <div class="form-group">
                                    <label>Happened On</label>
                                    <input type="text" class="form-control" uib-datepicker-popup
                                           ng-model="dirty.incident_at"
                                           is-open="dirty.incident_open"
                                           ng-required="true"
                                           close-text="Close"
                                           ng-click="dirty.incident_open = true"/>

                                    <div uib-timepicker ng-model="dirty.incident_time" hour-step="1" minute-step="1"
                                         show-meridian="false"></div>
                                </div>
                                <div class="form-group">
                                    <label>Driver</label>
                                    <button class="btn-xs btn btn-primary" ng-click="inferDriver()">Infer</button>
                                    <input class="form-control" readonly ng-model="dirty.driver.name">
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input class="form-control" ng-model="dirty.location">
                                </div>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>Type</label>
                                    <ui-select ng-model="dirty.type">
                                        <ui-select-match allow-clear="true">
                                            <span ng-bind="dirty.type"></span>
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="type in (vm.types | filter: $select.search) track by $index">
                                            <span ng-bind="type"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <ui-select ng-model="dirty.status">
                                        <ui-select-match allow-clear="true">
                                            <span ng-bind="dirty.status"></span>
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="status in (vm.statuses | filter: $select.search ) track by $index">
                                            <span ng-bind="status"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                <div class="form-group">
                                    <label>Weather Conditions</label>
                                    <input class="form-control" ng-model="dirty.weather_cond">
                                </div>
                                <div class="form-group">
                                    <label>Road Conditions</label>
                                    <input class="form-control" ng-model="dirty.road_cond">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4>3rd Party details</h4>
                    <hr>
                    <div class="row" tag="3rdparty">
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>3rd party Car Reg No</label>
                                    <input ng-model="dirty.x_car_reg" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>3rd party Car Details</label>
                                    <textarea ng-model="dirty.x_car_details" type="text"
                                              class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>3rd party Driver name</label>
                                    <input ng-model="dirty.x_driver_name" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>3rd party Driver details</label>
                                    <textarea ng-model="dirty.x_driver_licence" type="text"
                                              class="form-control"></textarea>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form">
                                <div class="form-group">
                                    <label>3rd party Insurance name</label>
                                    <textarea ng-model="dirty.x_insured_name" type="text"
                                              class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>3rd party Insurance Company</label>
                                    <textarea ng-model="dirty.x_insured_comp" type="text"
                                              class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>3rd party Insurance Policy</label>
                                    <textarea ng-model="dirty.x_insured_policy" type="text"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea ng-model="dirty.comments" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Police report</label>
                                <textarea ng-model="dirty.police_details" class="form-control"></textarea>
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
    </div>
</script>

