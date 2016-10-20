<script type="text/ng-template" id="revenue_list.html">
    <div class="table-container detail" ng-if="vm.investor.contracts.length > 0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="revenue in vm.investor.revenues | filter : {contract_id : vm.selected_contract}">
                <td>@{{ revenue.amount_paid }}</td>
                <td>@{{ formatDate(revenue.created_at) }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</script>
