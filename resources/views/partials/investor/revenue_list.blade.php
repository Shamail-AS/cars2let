<script type="text/ng-template" id="revenue_list.html">
    <div class="revenue-popover" ng-if="vm.contract_revenue_week_detail.length > 0">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Paid on</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="payment in vm.contract_revenue_week_detail">
                <td>@{{  payment.date }}</td>
                <td>@{{  payment.amount }}</td>
            </tr>
            </tbody>

        </table>

    </div>
</script>
