
<script type="text/ng-template" id="contract-rent.html">
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
                    <div ng-if="unallocated() < 0" class="alert alert-danger">
                        <strong>You can't allocate more than the receipts</strong>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="centered">
                                <p>
                                <h3>Unallocated Receipts:
                                    £@{{ unallocated() | number:2 }}</h3>
                                <small>payments(@{{ vm.contract.total_payments }}) -
                                    deposit(@{{ vm.contract.rec_deposit }}) -
                                    allocated(@{{ allocated() | number:2 }})
                                </small>
                                </p>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="centered">
                                <p>
                                <h3>Net Balance:
                                    £@{{ (grossBalance() + unallocated()) | number:2 }}</h3>
                                <small>gross(@{{ grossBalance() | number:2 }}) +
                                    unallocated(@{{ unallocated() | number:2 }})
                                </small>
                                </p>

                            </div>
                        </div>
                    </div>


                    <table class="table table-striped" id="revenues">
                        <thead>
                        <tr>
                            <th>Week</th>
                            <th>Date range [Actual End Date]</th>
                            <th>Rent Due(£)</th>
                            <th>Total Received(£)</th>
                            <th>Last Received At</th>
                            <th>Balance(£)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>0</td>
                            <td>-</td>
                            <td>@{{ vm.contract.req_deposit }} (Deposit)</td>
                            <td>
                                <input type="number" step="0.01" class="form-control"
                                       ng-model="vm.contract.rec_deposit">
                            </td>
                            <td>@{{ formatDate(vm.contract.updated_at) }}</td>
                            <td>@{{ (vm.contract.rec_deposit - vm.contract.req_deposit) | number : 2 }}</td>
                        </tr>
                        <tr ng-repeat="rev in vm.revenues " ng-class="rev.class">
                            <td>@{{ rev.week }}</td>
                            <td>@{{ rev.date_string }}</td>
                            <td>@{{ rev.amount_due }}</td>
                            <td ng-if="rev.class == 'enabled'"><input class="form-control" type="number" step="0.01"
                                                                      min="0" max="@{{ rev.amount_due }}" size="5"
                                                                      ng-model="rev.amount_received"></td>
                            <td ng-if="rev.class == 'enabled'">@{{ formatDate(rev.last_payment.date) }}</td>
                            <td ng-if="rev.class == 'enabled'">@{{ (rev.amount_received - rev.amount_due) | number:2 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th>Gross Balance</th>
                            <th>@{{ grossBalance() | number:2 }}</th>
                        </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button ng-disabled="!canSave()" type="button" ng-click="save()" class="btn btn-primary">
                            <i class="fa fa-spinner fa-spin" ng-show="vm.loading"></i> Save
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