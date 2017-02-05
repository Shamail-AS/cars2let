<script type="text/ng-template" id="contract-payments.html">
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" ng-click="close()" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Contract Payments</h4>
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
                    <form class="form-inline pull-right">
                        <div class="form-group">
                            <input type="hidden" id="csrf_token" ng-model="dirty.token" value="{{ csrf_token() }}">
                            <input ng-required="true" class="form-control" ng-model="dirty.amount" type="number"
                                   step="0.01" placeholder="Amount">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"
                                   uib-datepicker-popup
                                   ng-model="dirty.value_dt"
                                   is-open="dirty.picker"
                                   ng-required="true"
                                   close-text="Close"
                                   ng-click="dirty.picker = true"
                                   placeholder="Value Date"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" ng-model="dirty.comments" type="text" placeholder="Comments">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" ng-click="pay()">Pay</button>
                        </div>
                    </form>

                    <table class="table table-striped" id="revenues">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Recorded By</th>
                            <th>Comments</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="payment in vm.contract.payments | orderBy : '-id'">
                            <td>@{{ payment.id }}</td>
                            <td>@{{ formatDate(payment.value_dt) }}</td>
                            <td>@{{ payment.amount }}</td>
                            <td>@{{ payment.authorized_by.email }}</td>
                            <td><p>@{{ payment.comments }}</p></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" ng-click="save()" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>