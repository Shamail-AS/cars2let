<script type="text/ng-template" id="revenue_list.html">
    <div class="revenue-popover" ng-if="week.payments.length > 0">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Paid on</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="payment in week.payments">
                <td>@{{  formatDate(payment.created_on) }}</td>
                <td>@{{  payment.amount_paid }}</td>
            </tr>
            </tbody>

        </table>

    </div>
</script>
