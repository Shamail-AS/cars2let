<script type="text/ng-template" id="contract-payments.html">
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Contract Rent Allocation</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Planed Start</th>
                            <th>Actual Start</th>
                            <th>Planned End</th>
                            <th>Actual End</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>@{{ formatDate(vm.contract.start_date) }}</td>
                            <td>@{{ formatDate(vm.contract.act_start_dt) }}</td>
                            <td>@{{ formatDate(vm.contract.end_date) }}</td>
                            <td>@{{ formatDate(vm.contract.act_end_dt) }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div ng-if="!vm.contract.hasStarted" class="alert alert-warning">
                        <strong>This contract hasn't started yet!</strong>
                    </div>
                    <div ng-if="vm.contract.hasTerminatedEarly" class="alert alert-danger">
                        <strong>This contract was terminated early!</strong>
                    </div>

                    <table class="table table-striped" id="revenues">
                        <thead>
                        <tr>
                            <th>Week</th>
                            <th>Date range [Actual End Date]</th>
                            <th>Rent Due</th>
                            <th>Total Received</th>
                            <th>Last Received At</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="rev in vm.revenues " ng-class="rev.class">
                            <td>@{{ rev.week }}</td>
                            <td>@{{ rev.date_string }}</td>
                            <td>@{{ rev.amount_due }}</td>
                            <td ng-if="rev.class == 'enabled'"><input class="form-control" type="number" step="0.01"
                                                                      min="0" max="@{{ rev.amount_due }}" size="5"
                                                                      ng-model="rev.amount_received"></td>
                            <td ng-if="rev.class == 'enabled'">@{{ formatDate(rev.last_payment.date) }}</td>
                            <td ng-if="rev.class == 'enabled'">@{{ rev.balance }}</td>
                        </tr>
                        </tbody>
                    </table>
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